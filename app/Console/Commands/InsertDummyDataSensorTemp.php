<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class InsertDummyDataSensorTemp extends Command
{
    protected $signature = 'insert:dummy-sensor-temp';
    protected $description = 'Insert dummy sensor data every 5 minutes';

    public function handle()
    {
        $sensors = DB::table('sensors')
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
            ->where('sensors.sensor_measurement', 'Temperature')
            ->get();

        $now = now();
        $data = [];
        $alertsToNotify = [];

        foreach ($sensors as $sensor) {
            $levelRoll = rand(1, 100);

            if ($levelRoll <= 80) {
                $base = rand(25, 30);
                $red = $base + rand(-5, 5) / 10;
                $yellow = $base + rand(-5, 5) / 10;
                $blue = $base + rand(-5, 5) / 10;
            } elseif ($levelRoll <= 95) {
                $base = rand(25, 30);
                $red = $base + rand(-10, 10) / 10;
                $yellow = $base + rand(-15, 15) / 10;
                $blue = $base + rand(-10, 10) / 10;
            } else {
                $base = rand(25, 30);
                $red = $base + rand(-20, 20) / 10;
                $yellow = $base + rand(-25, 25) / 10;
                $blue = $base + rand(-20, 20) / 10;
            }

            $temps = [$red, $yellow, $blue];
            $max = max($temps);
            $min = min($temps);
            $variance = ($max - $min) / $max * 100;

            $alertLevel = match (true) {
                $variance >= 15 => 'critical',
                $variance >= 10 => 'warn',
                default => 'normal',
            };

            if (in_array($alertLevel, ['critical', 'warn'])) {
                $alertsToNotify[] = [
                    'sensor_id' => $sensor->sensor_id,
                    'sensor_name' => $sensor->sensor_name,
                    'measurement' => $sensor->sensor_measurement,
                    'substation' => $sensor->substation_name,
                    'panel' => $sensor->panel_name,
                    'compartment' => $sensor->compartment_name,
                    'alert_level' => $alertLevel,
                    'max_temp' => $max,
                    'variance_percent' => round($variance, 2),
                ];
            }

            $data[] = [
                'sensor_id' => $sensor->sensor_id,
                'red_phase_temp' => $red,
                'yellow_phase_temp' => $yellow,
                'blue_phase_temp' => $blue,
                'max_temp' => $max,
                'min_temp' => $min,
                'variance_percent' => round($variance, 2),
                'alert_triggered' => $alertLevel,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Error log management per sensor
            if (in_array($alertLevel, ['warn', 'critical'])) {
                if ($alertLevel === 'warn') {
                    $warnLog = DB::table('error_logs')
                        ->where('sensor_id', $sensor->sensor_id)
                        ->where('state', 'AWAIT')
                        ->first();

                    if ($warnLog) {
                        DB::table('error_logs')->where('id', $warnLog->id)->update(['updated_at' => $now]);
                        $this->info("Updated existing WARN log for sensor {$sensor->sensor_name}.");
                    } else {
                        $criticalLog = DB::table('error_logs')
                            ->where('sensor_id', $sensor->sensor_id)
                            ->where('state', 'ALARM')
                            ->first();

                        if ($criticalLog) {
                            DB::table('error_logs')->where('id', $criticalLog->id)->update([
                                'state' => 'AWAIT',
                                'threshold' => '>= 50 for 3600s',
                                'severity' => 'WARN',
                                'updated_at' => $now,
                            ]);
                            $this->info("Downgraded CRITICAL to WARN for sensor {$sensor->sensor_name}.");
                        } else {
                            DB::table('error_logs')->insert([
                                'sensor_id' => $sensor->sensor_id,
                                'state' => 'AWAIT',
                                'threshold' => '>= 50 for 3600s',
                                'severity' => 'WARN',
                                'pic' => 1,
                                'assigned_by' => null,
                                'desc' => null,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);
                            $this->info("Inserted new WARN log for sensor {$sensor->sensor_name}.");
                        }
                    }
                } elseif ($alertLevel === 'critical') {
                    $warnLog = DB::table('error_logs')
                        ->where('sensor_id', $sensor->sensor_id)
                        ->where('state', 'AWAIT')
                        ->first();

                    if ($warnLog) {
                        DB::table('error_logs')->where('id', $warnLog->id)->update([
                            'state' => 'ALARM',
                            'threshold' => '>= 50 for 300s',
                            'severity' => 'CRITICAL',
                            'updated_at' => $now,
                        ]);
                        $this->info("Upgraded WARN to CRITICAL for sensor {$sensor->sensor_name}.");
                    } else {
                        $criticalLog = DB::table('error_logs')
                            ->where('sensor_id', $sensor->sensor_id)
                            ->where('state', 'ALARM')
                            ->first();

                        if ($criticalLog) {
                            DB::table('error_logs')->where('id', $criticalLog->id)->update(['updated_at' => $now]);
                            $this->info("Updated existing CRITICAL log timestamp for sensor {$sensor->sensor_name}.");
                        } else {
                            DB::table('error_logs')->insert([
                                'sensor_id' => $sensor->sensor_id,
                                'state' => 'ALARM',
                                'threshold' => '>= 50 for 300s',
                                'severity' => 'CRITICAL',
                                'pic' => 1,
                                'assigned_by' => null,
                                'desc' => null,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);
                            $this->info("Inserted new CRITICAL log for sensor {$sensor->sensor_name}.");
                        }
                    }
                }

                // 🔔 Broadcast event per sensor
                event(new \App\Events\SensorAlertTriggered($sensor->sensor_id, $sensor->sensor_name, $alertLevel));
            }
        }

        // Bulk insert after all sensors processed
        if (!empty($data)) {
            DB::table('sensor_temperature')->insert($data);
        }

        // Send notifications to users with chat_id
        if (!empty($alertsToNotify)) {
            $users = User::whereNotNull('chat_id')->get();

            foreach ($users as $user) {
                foreach ($alertsToNotify as $alert) {
                    $user->notify(new SensorAlertNotification($alert, 'Temperature'));
                }
            }
        }

        $this->info('Inserted dummy data for ' . count($data) . ' sensors at ' . $now);
    }
}