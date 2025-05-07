<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsertDummyWarnData extends Command
{
    protected $signature = 'insert:dummy-warn';
    protected $description = 'Insert dummy warn sensor data';

    public function handle()
    {
        $sensor = DB::table('sensors')
            ->join('substations', 'sensors.sensor_substation', '=', 'substations.id')
            ->join('panels', 'sensors.sensor_panel', '=', 'panels.id')
            ->join('compartments', 'sensors.sensor_compartment', '=', 'compartments.id')
            ->select(
                'sensors.sensor_name',
                'sensors.sensor_measurement',
                'substations.substation_name as substation_name',
                'panels.panel_name as panel_name',
                'compartments.compartment_name as compartment_name'
            )
            ->where('sensors.sensor_measurement', 'Temperature')
            ->where('sensors.id', 1)
            ->first();

        $now = now();

        $red = 30.0;
        $yellow = 33.5;
        $blue = 30.2;
        $temps = [$red, $yellow, $blue];
        $max = max($temps);
        $min = min($temps);
        $variance = round(($max - $min) / $max * 100, 2);

        $alertLevel = match (true) {
            $variance >= 12 => 'critical',
            $variance >= 10 => 'warn',
            default => 'normal',
        };

        // Prepare dummy temperature insert
        DB::table('sensor_temperature')->insert([[
            'sensor_id' => 1,
            'red_phase_temp' => $red,
            'yellow_phase_temp' => $yellow,
            'blue_phase_temp' => $blue,
            'max_temp' => $max,
            'min_temp' => $min,
            'variance_percent' => $variance,
            'alert_triggered' => $alertLevel,
            'created_at' => $now,
            'updated_at' => $now,
        ]]);

        $alertsToNotify = [];

        if (in_array($alertLevel, ['critical', 'warn'])) {
            $alertsToNotify[] = [
                'sensor_id' => 1,
                'sensor_name' => $sensor->sensor_name,
                'measurement' => $sensor->sensor_measurement,
                'substation' => $sensor->substation_name,
                'panel' => $sensor->panel_name,
                'compartment' => $sensor->compartment_name,
                'alert_level' => $alertLevel,
                'max_temp' => $max,
                'variance_percent' => $variance,
            ];
        }

        // Send notifications
        if (!empty($alertsToNotify)) {
            $users = \App\Models\User::whereNotNull('chat_id')->get();

            foreach ($users as $user) {
                foreach ($alertsToNotify as $alert) {
                    $user->notify(new \App\Notifications\SensorAlertNotification($alert, 'Temperature'));
                }
            }
        }

        // Log error state changes
        if (in_array($alertLevel, ['warn', 'critical'])) {
            $sensorId = 1;

            if ($alertLevel === 'warn') {
                $warnLog = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'AWAIT')
                    ->first();

                if ($warnLog) {
                    DB::table('error_logs')->where('id', $warnLog->id)->update(['updated_at' => $now]);
                    $this->info('Updated existing WARN log timestamp.');
                } else {
                    $criticalLog = DB::table('error_logs')
                        ->where('sensor_id', $sensorId)
                        ->where('state', 'ALARM')
                        ->first();

                    if ($criticalLog) {
                        DB::table('error_logs')->where('id', $criticalLog->id)->update([
                            'state' => 'AWAIT',
                            'threshold' => '>= 50 for 3600s',
                            'severity' => 'WARN',
                            'updated_at' => $now,
                        ]);
                        $this->info('Downgraded CRITICAL to WARN.');
                    } else {
                        DB::table('error_logs')->insert([
                            'sensor_id' => $sensorId,
                            'state' => 'AWAIT',
                            'threshold' => '>= 50 for 3600s',
                            'severity' => 'WARN',
                            'pic' => 1,
                            'assigned_by' => null,
                            'desc' => null,
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);
                        $this->info('Inserted new WARN log.');
                    }
                }

            } elseif ($alertLevel === 'critical') {
                $warnLog = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'AWAIT')
                    ->first();

                if ($warnLog) {
                    DB::table('error_logs')->where('id', $warnLog->id)->update([
                        'state' => 'ALARM',
                        'threshold' => '>= 50 for 300s',
                        'severity' => 'CRITICAL',
                        'updated_at' => $now,
                    ]);
                    $this->info('Upgraded WARN to CRITICAL.');
                } else {
                    $criticalLog = DB::table('error_logs')
                        ->where('sensor_id', $sensorId)
                        ->where('state', 'ALARM')
                        ->first();

                    if ($criticalLog) {
                        DB::table('error_logs')->where('id', $criticalLog->id)->update(['updated_at' => $now]);
                        $this->info('Updated existing CRITICAL log timestamp.');
                    } else {
                        DB::table('error_logs')->insert([
                            'sensor_id' => $sensorId,
                            'state' => 'ALARM',
                            'threshold' => '>= 50 for 300s',
                            'severity' => 'CRITICAL',
                            'pic' => 1,
                            'assigned_by' => null,
                            'desc' => null,
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);
                        $this->info('Inserted new CRITICAL log.');
                    }
                }
            }

            // 🔔 Broadcast the event LAST
            $this->info('Broadcasting event...');
            event(new \App\Events\SensorAlertTriggered(1, $sensor->sensor_name, $alertLevel));
        }

        $this->info('Inserted dummy data at ' . $now);
    }
}
