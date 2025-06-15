<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            ->where('sensor_substation',1)
            // ->where('sensor_panel',1)
            ->where('sensors.sensor_status', 'Online')
            ->get();

        $now = now();
        $data = [];
        $alertsToNotify = [];

        foreach ($sensors as $sensor) {
            // Check the latest sensor data for this sensor
            $latestData = DB::table('sensor_temperature')
                ->where('sensor_id', $sensor->sensor_id)
                ->orderBy('created_at', 'desc')
                ->first();

            $shouldMaintainAlert = false;
            $maintainedAlertLevel = null;
            
            // Check if we should maintain the current alert state
            if ($latestData && in_array($latestData->alert_triggered, ['warn', 'critical'])) {
                $shouldMaintainAlert = true;
                $maintainedAlertLevel = $latestData->alert_triggered;
                $this->info("Maintaining {$maintainedAlertLevel} alert for sensor {$sensor->sensor_name}");
            }

            if ($shouldMaintainAlert) {
                // Generate normal base temperature for the two phases that are not problematic
                $baseTemp = rand(25, 30); // Normal temperature range
                
                // Randomly assign which phase gets the high temp (problematic phase)
                $phases = ['red', 'yellow', 'blue'];
                $hotPhaseIndex = array_rand($phases);
                $hotPhase = $phases[$hotPhaseIndex];
                
                // Calculate required temperature difference based on alert level
                if ($maintainedAlertLevel === 'critical') {
                    // For critical: diff >= 1
                    $requiredDiff = 1 + rand(0, 5) / 10; // 1.0 to 1.5
                } elseif ($maintainedAlertLevel === 'warn') {
                    // For warn: diff between 0.8 and 1
                    $requiredDiff = 0.8 + rand(0, 19) / 100; // 0.8 to 0.99
                }
                
                // Generate temperatures for the normal phases (keep them close to base)
                $otherPhases = array_diff($phases, [$hotPhase]);
                $otherPhases = array_values($otherPhases);
                
                // Generate normal temperatures for the other two phases
                $normalTemp1 = $baseTemp + rand(-3, 3) / 10; // Small variation around base
                $normalTemp2 = $baseTemp + rand(-3, 3) / 10; // Small variation around base
                
                // Make sure the normal temps are close to each other
                $minNormalTemp = min($normalTemp1, $normalTemp2);
                
                // Set the hot phase temperature to create the required difference
                $hotTemp = $minNormalTemp + $requiredDiff;
                
                // Assign temperatures to phases
                $temperatures = [];
                $temperatures[$hotPhase] = $hotTemp;
                $temperatures[$otherPhases[0]] = $normalTemp1;
                $temperatures[$otherPhases[1]] = $normalTemp2;
                
                $red = round($temperatures['red'], 2);
                $yellow = round($temperatures['yellow'], 2);
                $blue = round($temperatures['blue'], 2);
                
                // Recalculate values
                $temps = [$red, $yellow, $blue];
                $max = max($temps);
                $min = min($temps);
                $diff = round($max - $min, 2);
                $variance = round(($diff / $max) * 100, 2);
                $alertLevel = $maintainedAlertLevel;
                
                $this->info("Maintaining {$maintainedAlertLevel} alert for sensor {$sensor->sensor_name} - Hot phase: {$hotPhase} ({$max}°C), Normal phases: ~{$min}°C, Diff: {$diff}°C");
            } else {
                // Generate new dummy temperature readings normally
                $base = rand(25, 30);
                do {
                    $red = $base + rand(-5, 5) / 10;
                    $yellow = $base + rand(-5, 5) / 10;
                    $blue = $base + rand(-5, 5) / 10;

                    $temps = [$red, $yellow, $blue];
                    $max = max($temps);
                    $min = min($temps);
                    $diff = $max - $min;
                } while ($diff >= 0.8); // Keep generating until diff < 0.8

                $red = round($red, 2);
                $yellow = round($yellow, 2);
                $blue = round($blue, 2);
                $max = round($max, 2);
                $min = round($min, 2);
                $diff = round($diff, 2);
                $variance = round(($diff / $max) * 100, 2);

                // Determine alert level
                if ($diff >= 1) {
                    $alertLevel = 'critical';
                } elseif ($diff >= 0.8) {
                    $alertLevel = 'warn';
                } else {
                    $alertLevel = 'normal';
                }
            }

            // Save to alerts list for notifications
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
                    'variance_percent' => $variance,
                ];
            }

            // Prepare data for bulk insert
            $data[] = [
                'sensor_id' => $sensor->sensor_id,
                'red_phase_temp' => $red,
                'yellow_phase_temp' => $yellow,
                'blue_phase_temp' => $blue,
                'max_temp' => $max,
                'min_temp' => $min,
                'diff_temp' => $diff,
                'variance_percent' => $variance,
                'alert_triggered' => $alertLevel,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Handle error log management
            if (in_array($alertLevel, ['warn', 'critical'])) {
                $sensorType = 'App\\Models\\SensorTemperature'; // Polymorphic type for temperature data

                if ($alertLevel === 'warn') {
                    $warnLog = DB::table('error_logs')
                        ->where('sensor_id', $sensor->sensor_id)
                        ->where('sensor_type', $sensorType)
                        ->where('state', 'AWAIT')
                        ->first();

                    if ($warnLog) {
                        // Update timestamp
                        DB::table('error_logs')->where('id', $warnLog->id)->update(['updated_at' => $now]);
                        $this->info("Updated existing WARN log for sensor {$sensor->sensor_name}.");
                    } else {
                        // Check if there is an active critical log to downgrade
                        $criticalLog = DB::table('error_logs')
                            ->where('sensor_id', $sensor->sensor_id)
                            ->where('sensor_type', $sensorType)
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
                        } 
                        // else {
                        //     DB::table('error_logs')->insert([
                        //         'sensor_id' => $sensor->sensor_id,
                        //         'sensor_type' => $sensorType,
                        //         'state' => 'AWAIT',
                        //         'threshold' => '>= 50 for 3600s',
                        //         'severity' => 'WARN',
                        //         'pic' => 1,
                        //         'assigned_by' => null,
                        //         'desc' => null,
                        //         'status' => 'New',
                        //         'created_at' => $now,
                        //         'updated_at' => $now,
                        //     ]);
                        //     $this->info("Inserted new WARN log for sensor {$sensor->sensor_name}.");
                        // }
                    }
                } elseif ($alertLevel === 'critical') {
                    $warnLog = DB::table('error_logs')
                        ->where('sensor_id', $sensor->sensor_id)
                        ->where('sensor_type', $sensorType)
                        ->where('state', 'AWAIT')
                        ->first();

                    if ($warnLog) {
                        // Upgrade warn to critical
                        DB::table('error_logs')->where('id', $warnLog->id)->update([
                            'state' => 'ALARM',
                            'threshold' => '>= 50 for 300s',
                            'severity' => 'CRITICAL',
                            'updated_at' => $now,
                        ]);
                        $this->info("Upgraded WARN to CRITICAL for sensor {$sensor->sensor_name}.");
                    } else {
                        // Check for existing critical log
                        $criticalLog = DB::table('error_logs')
                            ->where('sensor_id', $sensor->sensor_id)
                            ->where('sensor_type', $sensorType)
                            ->where('state', 'ALARM')
                            ->first();

                        if ($criticalLog) {
                            DB::table('error_logs')->where('id', $criticalLog->id)->update(['updated_at' => $now]);
                            $this->info("Updated existing CRITICAL log timestamp for sensor {$sensor->sensor_name}.");
                        } 
                        // else {
                        //     DB::table('error_logs')->insert([
                        //         'sensor_id' => $sensor->sensor_id,
                        //         'sensor_type' => $sensorType,
                        //         'state' => 'ALARM',
                        //         'threshold' => '>= 50 for 300s',
                        //         'severity' => 'CRITICAL',
                        //         'pic' => 1,
                        //         'assigned_by' => null,
                        //         'desc' => null,
                        //         'status' => 'New',
                        //         'created_at' => $now,
                        //         'updated_at' => $now,
                        //     ]);
                        //     $this->info("Inserted new CRITICAL log for sensor {$sensor->sensor_name}.");
                        // }
                    }
                }

            }
        }

        // Bulk insert sensor temperature data
        if (!empty($data)) {
            DB::table('sensor_temperature')->insert($data);
        }

        $this->info('Inserted dummy data for ' . count($data) . ' sensors at ' . $now);
    }
}