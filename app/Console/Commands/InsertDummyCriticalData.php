<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
use App\Models\SensorTemperature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InsertDummyCriticalData extends Command
{
    /** php artisan insert:dummy-critical {sensor_id?} */
    protected $signature   = 'insert:dummy-critical {sensor_id?}';
    protected $description = 'Insert dummy *critical* sensor-temperature data';

    public function handle(): void
    {
        /** -----------------------------------------------------------
         *  1. Locate a temperature sensor (same logic as warn command)
         * ----------------------------------------------------------- */
        $sensorId = $this->argument('sensor_id');

        if (!$sensorId) {
            $latest = DB::table('sensor_temperature')
                ->join('sensors', 'sensor_temperature.sensor_id', '=', 'sensors.id')
                ->where('sensors.id', 1)
                ->orderByDesc('sensor_temperature.created_at')
                ->first();

            if ($latest) {
                $sensorId = $latest->sensor_id;
                $this->info("Using latest sensor ID: {$sensorId}");
            } else {
                $first = DB::table('sensors')
                    ->where('sensor_measurement', 'Temperature')
                    ->where('sensor_status', 'Online')
                    ->first();

                if (!$first) {
                    $this->error('No temperature sensors found!');
                    return;
                }
                $sensorId = $first->id;
                $this->info("Using first available temperature sensor ID: {$sensorId}");
            }
        }

        /** -----------------------------------------------------------
         *  2. Fetch sensor metadata for logging / notifications
         * ----------------------------------------------------------- */
        $sensor = DB::table('sensors')
            ->join('substations',  'sensors.sensor_substation', '=', 'substations.id')
            ->join('panels',       'sensors.sensor_panel',      '=', 'panels.id')
            ->join('compartments', 'sensors.sensor_compartment','=','compartments.id')
            ->select(
                'sensors.id   as sensor_id',
                'sensors.sensor_name',
                'sensors.sensor_measurement',
                'substations.substation_name as substation_name',
                'panels.panel_name           as panel_name',
                'compartments.compartment_name as compartment_name'
            )
            ->where('sensors.id', $sensorId)
            ->where('sensors.sensor_measurement', 'Temperature')
            ->first();

        if (!$sensor) {
            $this->error("Sensor with ID {$sensorId} not found or not a temperature sensor!");
            return;
        }

        /** -----------------------------------------------------------
         *  3. Generate *critical-level* temperatures
         *     We guarantee ΔT > 1.0 °C
         * ----------------------------------------------------------- */
        $now       = now();
        $baseTemp  = 30 + (rand(-50, 50) / 100);        // 29.50-30.50
        $red       = round($baseTemp,  2);
        $blue      = round($baseTemp + (rand(-10, 10) / 100), 2);  // ±0.10 °C
        $targetDiff= 1.05 + (rand(0, 25) / 100);        // 1.05-1.30 °C
        $yellow    = round($red + $targetDiff, 2);

        $temps     = [$red, $yellow, $blue];
        $max       = max($temps);
        $min       = min($temps);
        $diff      = round($max - $min, 2);
        $variance  = round(($max - $min) / $max * 100, 2);

        // Safety net: force critical if somehow diff slipped below 1.01 °C
        if ($diff <= 1.0) {
            $yellow   = round($red + 1.15, 2);
            $temps    = [$red, $yellow, $blue];
            $max      = max($temps);
            $min      = min($temps);
            $diff     = round($max - $min, 2);
            $variance = round(($max - $min) / $max * 100, 2);
        }

        $alertLevel = 'critical';   // we know diff > 1.0

        $this->info("Generated temperatures – R:{$red}°C  Y:{$yellow}°C  B:{$blue}°C");
        $this->info("ΔT: {$diff}°C, Variance: {$variance}%, Alert: {$alertLevel}");

        /** -----------------------------------------------------------
         *  4. Persist the temperature reading
         * ----------------------------------------------------------- */
        DB::table('sensor_temperature')->insert([
            'sensor_id'         => $sensorId,
            'red_phase_temp'    => $red,
            'yellow_phase_temp' => $yellow,
            'blue_phase_temp'   => $blue,
            'max_temp'          => $max,
            'min_temp'          => $min,
            'diff_temp'         => $diff,
            'variance_percent'  => $variance,
            'alert_triggered'   => $alertLevel,
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        /** -----------------------------------------------------------
         *  5. Error-log handling (upgrade warn→critical, etc.)
         * ----------------------------------------------------------- */
        $errorLogId = null;
        // $errorId    = $sensorId;
        $errorType  = SensorTemperature::class;

        // Existing WARN? upgrade
        $existingWarn = DB::table('error_logs')
            ->where('sensor_id', $sensorId)
            ->where('sensor_type', $errorType)
            ->where('state', 'AWAIT')   // WARN state
            ->first();

        if ($existingWarn) {
            DB::table('error_logs')->where('id', $existingWarn->id)->update([
                'state'      => 'ALARM',
                'threshold'  => '>= 50 for 300s',
                'severity'   => 'CRITICAL',
                'updated_at' => $now,
            ]);
            $errorLogId = $existingWarn->id;
            $this->info('Upgraded WARN → CRITICAL.');
        } else {
            // Existing critical? just touch timestamp
            $existingCrit = DB::table('error_logs')
                ->where('sensor_id', $sensorId)
                ->where('sensor_type', $errorType)
                ->where('state', 'ALARM')
                ->first();

            if ($existingCrit) {
                DB::table('error_logs')->where('id', $existingCrit->id)->update(['updated_at' => $now]);
                $errorLogId = $existingCrit->id;
                $this->info('Updated existing CRITICAL timestamp.');
            } else {
                // Brand-new critical log
                $errorLogId = DB::table('error_logs')->insertGetId([
                    'sensor_id'    => $sensorId,
                    'sensor_type'  => $errorType,
                    'state'        => 'ALARM',
                    'threshold'    => '>= 50 for 300s',
                    'severity'     => 'CRITICAL',
                    'pic'          => 1,
                    'status'       => 'New',
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
                $this->info('Inserted new CRITICAL log.');
            }
        }

        /** -----------------------------------------------------------
         *  6. Broadcast + Telegram
         * ----------------------------------------------------------- */
        try {
            event(new \App\Events\SensorAlertTriggered($sensorId, $sensor->sensor_name, $alertLevel));
            event(new NotificationEvent(
                'Sensor ' . $sensor->sensor_measurement . ' Alert',
                "Error Log ID: #{$errorLogId}<br>Sensor Name: {$sensor->sensor_name}"
            ));
        } catch (\Exception $e) {
            Log::error('Broadcast failed: '.$e->getMessage());
            $this->error('Broadcast failed: '.$e->getMessage());
        }

        // Telegram
        try {
            (new \App\Notifications\SensorAlertNotification([
                'sensor_id'        => $sensorId,
                'sensor_name'      => $sensor->sensor_name,
                'measurement'      => $sensor->sensor_measurement,
                'substation'       => $sensor->substation_name,
                'panel'            => $sensor->panel_name,
                'compartment'      => $sensor->compartment_name,
                'alert_level'      => $alertLevel,
                'diff_temp'        => $diff,
                'variance_percent' => $variance,
                'error_log_id'     => $errorLogId,
            ], 'Temperature'))->sendTelegramMessage();
            $this->info('Telegram notification sent.');
        } catch (\Exception $e) {
            Log::error('Telegram failed: '.$e->getMessage());
            $this->error('Telegram failed: '.$e->getMessage());
        }

        /** -----------------------------------------------------------
         *  7. Done
         * ----------------------------------------------------------- */
        $this->info("✅  Inserted dummy *critical* data for sensor {$sensor->sensor_name} (ID {$sensorId}) at {$now}");
        $this->info("    ΔT {$diff}°C, Variance {$variance}%  —  ErrorLog #{$errorLogId}");
    }
}
