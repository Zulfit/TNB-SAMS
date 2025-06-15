<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
use App\Models\SensorTemperature;
use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InsertDummyWarnData extends Command
{
    protected $signature = 'insert:dummy-warn {sensor_id?}';
    protected $description = 'Insert dummy warn sensor data';

    public function handle()
    {
        // Get sensor ID from command argument or find the latest one
        $sensorId = $this->argument('sensor_id');

        if (!$sensorId) {
            // Method 1: Get the sensor_id from the latest temperature record
            $latestTempRecord = DB::table('sensor_temperature')
                ->join('sensors', 'sensor_temperature.sensor_id', '=', 'sensors.id')
                ->where('sensors.id', 1)
                ->orderBy('sensor_temperature.created_at', 'desc')
                ->first();

            if ($latestTempRecord) {
                $sensorId = $latestTempRecord->sensor_id;
                $this->info("Using latest sensor ID: {$sensorId}");
            } else {
                // Fallback: Get the first available temperature sensor
                $firstTempSensor = DB::table('sensors')
                    ->where('sensor_measurement', 'Temperature')
                    ->where('sensor_status', 'Online')
                    ->first();

                if ($firstTempSensor) {
                    $sensorId = $firstTempSensor->id;
                    $this->info("Using first available temperature sensor ID: {$sensorId}");
                } else {
                    $this->error("No temperature sensors found!");
                    return;
                }
            }
        }

        // Get sensor details using the determined sensor ID
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
            ->where('sensors.sensor_measurement', 'Temperature')
            ->where('sensors.id', $sensorId)
            ->first();

        if (!$sensor) {
            $this->error("Sensor with ID {$sensorId} not found or is not a temperature sensor!");
            return;
        }

        $now = now();

        // Get the latest temperature data for this sensor
        $latestData = DB::table('sensor_temperature')
            ->where('sensor_id', $sensorId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($latestData) {
            $this->info("Latest sensor state: {$latestData->alert_triggered}");
        }

        // Always generate warn-level data (force warn regardless of previous state)
        // Generate temperatures with difference > 0.8 and <= 1 to trigger warn
        $baseTemp = 30.0 + (rand(-50, 50) / 100); // Add some randomness to base temp
        $red = round($baseTemp, 2);
        $blue = round($baseTemp + (rand(-10, 10) / 100), 2); // Small variation from base
        
        // Generate yellow temp to create warn-level difference (0.8 < diff <= 1.0)
        $targetDiff = 0.85 + (rand(0, 15) / 100); // Random between 0.85 and 1.00
        $yellow = round($red + $targetDiff, 2);

        $temps = [$red, $yellow, $blue];
        $max = max($temps);
        $min = min($temps);
        $diff = round($max - $min, 2);
        $variance = round(($max - $min) / $max * 100, 2);

        // Ensure we get warn level (0.8 < diff <= 1.0)
        if ($diff <= 0.8) {
            // Adjust to ensure warn level
            $yellow = round($red + 0.9, 2); // Set difference to 0.9
            $temps = [$red, $yellow, $blue];
            $max = max($temps);
            $min = min($temps);
            $diff = round($max - $min, 2);
            $variance = round(($max - $min) / $max * 100, 2);
        } elseif ($diff > 1.0) {
            // Adjust to keep it in warn range
            $yellow = round($red + 0.95, 2); // Set difference to 0.95
            $temps = [$red, $yellow, $blue];
            $max = max($temps);
            $min = min($temps);
            $diff = round($max - $min, 2);
            $variance = round(($max - $min) / $max * 100, 2);
        }

        $alertLevel = match (true) {
            $diff > 1.0 => 'critical',
            $diff > 0.8 => 'warn',
            default => 'normal',
        };

        $this->info("Generated temperatures - Red: {$red}°C, Yellow: {$yellow}°C, Blue: {$blue}°C");
        $this->info("Temperature Difference: {$diff}°C, Variance: {$variance}%, Alert Level: {$alertLevel}");

        // Insert the sensor data
        DB::table('sensor_temperature')->insert([
            [
                'sensor_id' => $sensorId,
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
            ]
        ]);

        $errorId = $sensorId;
        $errorType = SensorTemperature::class;
        $errorLogId = null;

        // Log error state changes only for warn/critical
        if (in_array($alertLevel, ['warn', 'critical'])) {
            if ($alertLevel === 'warn') {
                // Check for existing warn log
                $existingWarnLog = DB::table('error_logs')
                    ->where('sensor_id', $errorId)
                    ->where('sensor_type', $errorType)
                    ->where('state', 'AWAIT')
                    ->first();

                if ($existingWarnLog) {
                    // Update existing warn log timestamp
                    DB::table('error_logs')->where('id', $existingWarnLog->id)->update(['updated_at' => $now]);
                    $errorLogId = $existingWarnLog->id;
                    $this->info('Updated existing WARN log timestamp.');
                } else {
                    // Check if there's a critical log to downgrade
                    $existingCriticalLog = DB::table('error_logs')
                        ->where('sensor_id', $errorId)
                        ->where('sensor_type', $errorType)
                        ->where('state', 'ALARM')
                        ->first();

                    if ($existingCriticalLog) {
                        // Downgrade critical to warn
                        DB::table('error_logs')->where('id', $existingCriticalLog->id)->update([
                            'state' => 'AWAIT',
                            'threshold' => '>= 50 for 3600s',
                            'severity' => 'WARN',
                            'updated_at' => $now,
                        ]);
                        $errorLogId = $existingCriticalLog->id;
                        $this->info('Downgraded CRITICAL to WARN.');
                    } else {
                        // Create new warn log
                        $errorLogId = DB::table('error_logs')->insertGetId([
                            'sensor_id' => $errorId,
                            'sensor_type' => $errorType,
                            'state' => 'AWAIT',
                            'threshold' => '>= 50 for 3600s',
                            'severity' => 'WARN',
                            'pic' => 1,
                            'assigned_by' => null,
                            'desc' => null,
                            'status' => 'New',
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);
                        $this->info('Inserted new WARN log.');
                    }
                }
            } elseif ($alertLevel === 'critical') {
                // Handle critical alerts
                $existingWarnLog = DB::table('error_logs')
                    ->where('sensor_id', $errorId)
                    ->where('sensor_type', $errorType)
                    ->where('state', 'AWAIT')
                    ->first();

                if ($existingWarnLog) {
                    // Upgrade warn to critical
                    DB::table('error_logs')->where('id', $existingWarnLog->id)->update([
                        'state' => 'ALARM',
                        'threshold' => '>= 50 for 300s',
                        'severity' => 'CRITICAL',
                        'updated_at' => $now,
                    ]);
                    $errorLogId = $existingWarnLog->id;
                    $this->info('Upgraded WARN to CRITICAL.');
                } else {
                    $existingCriticalLog = DB::table('error_logs')
                        ->where('sensor_id', $errorId)
                        ->where('sensor_type', $errorType)
                        ->where('state', 'ALARM')
                        ->first();

                    if ($existingCriticalLog) {
                        DB::table('error_logs')->where('id', $existingCriticalLog->id)->update(['updated_at' => $now]);
                        $errorLogId = $existingCriticalLog->id;
                        $this->info('Updated existing CRITICAL log timestamp.');
                    } else {
                        $errorLogId = DB::table('error_logs')->insertGetId([
                            'sensor_id' => $errorId,
                            'sensor_type' => $errorType,
                            'state' => 'ALARM',
                            'threshold' => '>= 50 for 300s',
                            'severity' => 'CRITICAL',
                            'pic' => 1,
                            'assigned_by' => null,
                            'desc' => null,
                            'status' => 'New',
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);
                        $this->info('Inserted new CRITICAL log.');
                    }
                }
            }

            // Broadcast events
            $this->info('Broadcasting event...');
            try {
                event(new \App\Events\SensorAlertTriggered($sensorId, $sensor->sensor_name, $alertLevel));
                event(new NotificationEvent(
                    'Sensor ' . $sensor->sensor_measurement . ' Alert',
                    "Error Log ID: #{$errorLogId}<br>Sensor Name: {$sensor->sensor_name}"
                ));
            } catch (\Exception $e) {
                Log::error('Broadcast failed: ' . $e->getMessage());
                $this->error('Broadcast failed: ' . $e->getMessage());
            }

            // Send Telegram notifications
            $alertsToNotify = [];
            if (in_array($alertLevel, ['critical', 'warn'])) {
                $alertsToNotify[] = [
                    'sensor_id' => $sensorId,
                    'sensor_name' => $sensor->sensor_name,
                    'measurement' => $sensor->sensor_measurement,
                    'substation' => $sensor->substation_name,
                    'panel' => $sensor->panel_name,
                    'compartment' => $sensor->compartment_name,
                    'alert_level' => $alertLevel,
                    'diff_temp' => $diff,
                    'variance_percent' => $variance,
                    'error_log_id' => $errorLogId,
                ];
            }

            foreach ($alertsToNotify as $alert) {
                try {
                    (new SensorAlertNotification($alert, 'Temperature'))->sendTelegramMessage();
                    $this->info('Telegram notification sent successfully.');
                } catch (\Exception $e) {
                    Log::error('Telegram notification failed: ' . $e->getMessage());
                    $this->error('Telegram notification failed: ' . $e->getMessage());
                }
            }
        }

        $this->info("Successfully inserted dummy warn data for sensor ID: {$sensorId} ({$sensor->sensor_name}) at {$now}");
        $this->info("Final Alert Level: {$alertLevel}, Temperature Difference: {$diff}°C, Variance: {$variance}%");
        
        if ($errorLogId) {
            $this->info("Error Log ID: {$errorLogId}");
        }
    }
}