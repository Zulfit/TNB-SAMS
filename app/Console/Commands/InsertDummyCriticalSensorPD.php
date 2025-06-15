<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InsertDummyCriticalSensorPD extends Command
{
    protected $signature = 'insert:dummy-critical-sensor-pd {sensorId}';
    protected $description = 'Insert dummy Partial Discharge sensor data (always critical) for specific sensor ID';

    public function handle()
    {
        $sensorId = (int) $this->argument('sensorId');

        if (!$sensorId) {
            $this->error('Please provide a valid sensor ID.');
            return;
        }

        $sensor = DB::table('sensors')
            ->join('substations', 'sensors.sensor_substation', '=', 'substations.id')
            ->join('panels', 'sensors.sensor_panel', '=', 'panels.id')
            ->join('compartments', 'sensors.sensor_compartment', '=', 'compartments.id')
            ->select(
                'sensors.id as sensor_id',
                'sensors.sensor_name',
                'sensors.sensor_measurement',
                'substations.substation_name as substation_name',
                'panels.panel_name as panel_name',
                'compartments.compartment_name as compartment_name'
            )
            ->where('sensors.id', $sensorId)
            ->where('sensors.sensor_measurement', 'Partial Discharge')
            ->first();

        if (!$sensor) {
            $this->error("Sensor with ID {$sensorId} not found or is not a Partial Discharge sensor.");
            return;
        }

        $now = Carbon::now();

        // Generate synthetic critical values with indicator between 0 and 1
        $lfbRatio = 10 + rand(0, 100) / 100; // e.g. 10.00 to 11.00 dB
        $mfbRatio = 11 + rand(0, 100) / 100;
        $hfbRatio = 12 + rand(0, 100) / 100;

        $lfbEPPC = 0.01 + rand(0, 30) / 1000; // e.g. 0.01 to 0.04
        $mfbEPPC = 0.02 + rand(0, 30) / 1000;
        $hfbEPPC = 0.03 + rand(0, 30) / 1000;

        $lfbLinear = pow(10, $lfbRatio / 10);
        $mfbLinear = pow(10, $mfbRatio / 10);
        $hfbLinear = pow(10, $hfbRatio / 10);

        $meanLinear = ($lfbLinear + $mfbLinear + $hfbLinear) / 3;
        $meanRatio = 10 * log10($meanLinear);
        $meanEPPC = ($lfbEPPC + $mfbEPPC + $hfbEPPC) / 3;

        // Calculate indicator to be between 0 and 1 for critical alert
        $indicator = round($meanRatio * $meanEPPC, 2);
        
        // Ensure indicator is between 0 and 1
        if ($indicator >= 1.0) {
            $indicator = 0.1 + rand(0, 800) / 1000; // 0.1 to 0.9
            $indicator = round($indicator, 2);
        } elseif ($indicator <= 0) {
            $indicator = 0.1 + rand(0, 800) / 1000; // 0.1 to 0.9
            $indicator = round($indicator, 2);
        }

        $alert = 'critical';

        $data = [
            'sensor_id' => $sensor->sensor_id,
            'LFB_Ratio' => $lfbRatio,
            'LFB_Ratio_Linear' => $lfbLinear,
            'MFB_Ratio' => $mfbRatio,
            'MFB_Ratio_Linear' => $mfbLinear,
            'HFB_Ratio' => $hfbRatio,
            'HFB_Ratio_Linear' => $hfbLinear,
            'Mean_Ratio' => round($meanRatio, 2),
            'LFB_EPPC' => $lfbEPPC,
            'MFB_EPPC' => $mfbEPPC,
            'HFB_EPPC' => $hfbEPPC,
            'Mean_EPPC' => round($meanEPPC, 2),
            'Indicator' => $indicator,
            'alert_triggered' => $alert,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $alertToNotify = [
            'sensor_id' => $sensor->sensor_id,
            'sensor_name' => $sensor->sensor_name,
            'measurement' => $sensor->sensor_measurement,
            'substation' => $sensor->substation_name,
            'panel' => $sensor->panel_name,
            'compartment' => $sensor->compartment_name,
            'alert_level' => $alert,
            'indicator' => $indicator,
        ];

        // Trigger event
        event(new \App\Events\SensorAlertTriggered(
            $sensor->sensor_id,
            $sensor->sensor_name,
            $alert
        ));

        // Check if error log already exists for this sensor
        $existingErrorLog = DB::table('error_logs')
            ->where('sensor_id', $sensor->sensor_id)
            ->where('sensor_type', 'App\\Models\\SensorPartialDischarge')
            ->where('state', 'ALARM')
            ->first();

        if ($existingErrorLog) {
            // Update existing error log with new timestamp
            DB::table('error_logs')
                ->where('id', $existingErrorLog->id)
                ->update([
                    'updated_at' => $now,
                ]);
            
            $this->info("Updated existing error log for sensor ID: {$sensor->sensor_id}");
        } else {
            // Create new error log
            DB::table('error_logs')->insert([
                'sensor_id' => $sensor->sensor_id,
                'sensor_type' => 'App\\Models\\SensorPartialDischarge',
                'state' => 'ALARM',
                'threshold' => '>= 50 for 300s',
                'severity' => 'CRITICAL',
                'pic' => 1,
                'assigned_by' => null,
                'desc' => null,
                'status' => 'New',
                'updated_at' => $now,
                'created_at' => $now,
            ]);
            
            $this->info("Created new error log for sensor ID: {$sensor->sensor_id}");
        }

        // Insert sensor data
        DB::table('sensor_partial_discharge')->insert($data);

        // Send notification
        try {
            (new SensorAlertNotification($alertToNotify, 'Partial Discharge'))->sendTelegramMessage();
            $this->info('Telegram notification sent successfully.');
        } catch (\Exception $e) {
            Log::error('Telegram notification failed: ' . $e->getMessage());
            $this->error('Telegram notification failed: ' . $e->getMessage());
        }

        $this->info("Inserted dummy CRITICAL Partial Discharge data for sensor ID: {$sensor->sensor_id} with indicator: {$indicator}");
    }
}