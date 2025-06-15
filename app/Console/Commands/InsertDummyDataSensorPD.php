<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsertDummyDataSensorPD extends Command
{
    protected $signature = 'insert:dummy-sensor-pd';
    protected $description = 'Insert dummy Partial Discharge sensor data every 5 minutes';

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
            ->where('sensors.sensor_measurement', 'Partial Discharge')
            ->where('sensors.sensor_substation',1)
            // ->where('sensors.sensor_panel',1)
            ->where('sensors.sensor_status', 'Online')
            ->get();

        $now = now();
        $data = [];
        $alertsToNotify = [];

        foreach ($sensors as $sensor) {
            // Check the latest sensor data for this sensor
            $latestData = DB::table('sensor_partial_discharge')
                ->where('sensor_id', $sensor->sensor_id)
                ->orderBy('created_at', 'desc')
                ->first();

            $shouldMaintainAlert = false;
            
            // Check if we should maintain the current alert state
            if ($latestData && $latestData->alert_triggered === 'critical') {
                $shouldMaintainAlert = true;
                $this->info("Maintaining critical alert for sensor {$sensor->sensor_name}");
            }

            if ($shouldMaintainAlert) {
                // Maintain critical state with indicator between 0.01 and 0.99
                // $indicator = 0.01 + (rand(1, 98) / 100); 
                
                // Generate realistic values that would produce this indicator
                // Using previous values as base with small variations
                $lfbRatio = $latestData->LFB_Ratio ?? 0;
                $mfbRatio = $latestData->MFB_Ratio ?? 0;
                $hfbRatio = $latestData->HFB_Ratio ?? 0;
                $lfbEPPC = $latestData->LFB_EPPC ?? 0;
                $mfbEPPC = $latestData->MFB_EPPC ?? 0;
                $hfbEPPC = $latestData->HFB_EPPC ?? 0;
                // $lfbRatio = $mfbRatio = $hfbRatio = 0;
                // $lfbEPPC = $mfbEPPC = $hfbEPPC = 0;
                
                // Add small variations (±10%)
                $variation = 0.1;
                $lfbRatio += ($lfbRatio * $variation * (rand(-100, 100) / 100));
                $mfbRatio += ($mfbRatio * $variation * (rand(-100, 100) / 100));
                $hfbRatio += ($hfbRatio * $variation * (rand(-100, 100) / 100));
                $lfbEPPC += ($lfbEPPC * $variation * (rand(-100, 100) / 100));
                $mfbEPPC += ($mfbEPPC * $variation * (rand(-100, 100) / 100));
                $hfbEPPC += ($hfbEPPC * $variation * (rand(-100, 100) / 100));
                
                // // If previous values were all zero, generate some non-zero values
                // if ($lfbRatio == 0 && $mfbRatio == 0 && $hfbRatio == 0) {
                //     $lfbRatio = rand(1, 50) / 10; // 0.1 to 5.0
                //     $mfbRatio = rand(1, 50) / 10;
                //     $hfbRatio = rand(1, 50) / 10;
                // }
                
                // if ($lfbEPPC == 0 && $mfbEPPC == 0 && $hfbEPPC == 0) {
                //     $lfbEPPC = rand(1, 100) / 100; // 0.01 to 1.0
                //     $mfbEPPC = rand(1, 100) / 100;
                //     $hfbEPPC = rand(1, 100) / 100;
                // }
                
                // Calculate linear values
                $lfbLinear = pow(10, $lfbRatio / 10);
                $mfbLinear = pow(10, $mfbRatio / 10);
                $hfbLinear = pow(10, $hfbRatio / 10);

                $meanLinear = ($lfbLinear + $mfbLinear + $hfbLinear) / 3;
                $meanRatio = $meanLinear > 0 ? 10 * log10($meanLinear) : 0;
                $meanEPPC = ($lfbEPPC + $mfbEPPC + $hfbEPPC) / 3;
                $indicator = round($meanRatio * $meanEPPC, 2);
                // $indicator = 0;
                // Use the generated indicator (between 0.01 and 0.99)
                $alert = 'critical';
                
            } else {
                // Generate normal data (all zeros = indicator 0)
                $lfbRatio = $mfbRatio = $hfbRatio = 0;
                $lfbEPPC = $mfbEPPC = $hfbEPPC = 0;

                $lfbLinear = pow(10, $lfbRatio / 10);
                $mfbLinear = pow(10, $mfbRatio / 10);
                $hfbLinear = pow(10, $hfbRatio / 10);

                $meanLinear = ($lfbLinear + $mfbLinear + $hfbLinear) / 3;
                $meanRatio = $meanLinear > 0 ? 10 * log10($meanLinear) : 0;
                $meanEPPC = ($lfbEPPC + $mfbEPPC + $hfbEPPC) / 3;

                $indicator = 0; // Always 0 for normal state
                $alert = 'normal';
            }

            $data[] = [
                'sensor_id' => $sensor->sensor_id,
                'LFB_Ratio' => round($lfbRatio, 2),
                'LFB_Ratio_Linear' => round($lfbLinear, 4),
                'MFB_Ratio' => round($mfbRatio, 2),
                'MFB_Ratio_Linear' => round($mfbLinear, 4),
                'HFB_Ratio' => round($hfbRatio, 2),
                'HFB_Ratio_Linear' => round($hfbLinear, 4),
                'Mean_Ratio' => round($meanRatio, 2),
                'LFB_EPPC' => round($lfbEPPC, 2),
                'MFB_EPPC' => round($mfbEPPC, 2),
                'HFB_EPPC' => round($hfbEPPC, 2),
                'Mean_EPPC' => round($meanEPPC, 2),
                'Indicator' => round($indicator, 2),
                'alert_triggered' => $alert,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Handle critical alerts
            if ($alert === 'critical') {
                $alertData = [
                    'sensor_id' => $sensor->sensor_id,
                    'sensor_name' => $sensor->sensor_name,
                    'measurement' => $sensor->sensor_measurement,
                    'substation' => $sensor->substation_name,
                    'panel' => $sensor->panel_name,
                    'compartment' => $sensor->compartment_name,
                    'alert_level' => $alert,
                    'indicator' => $indicator,
                ];

                $alertsToNotify[] = $alertData;

                // Handle error log management
                $this->handleErrorLog($sensor->sensor_id, $sensor->sensor_name, $now);
            }
        }

        // Bulk insert sensor partial discharge data
        if (!empty($data)) {
            DB::table('sensor_partial_discharge')->insert($data);
            $this->info('Inserted dummy data for ' . count($data) . ' sensors at ' . $now);
        }

        // Log alerts summary
        if (!empty($alertsToNotify)) {
            $this->info('Critical alerts maintained for ' . count($alertsToNotify) . ' sensors.');
        }
    }

    /**
     * Handle error log creation or update for critical sensors
     */
    private function handleErrorLog($sensorId, $sensorName, $now)
    {
        $sensorType = 'App\\Models\\SensorPartialDischarge';

        // Check for existing critical log
        $existingLog = DB::table('error_logs')
            ->where('sensor_id', $sensorId)
            ->where('sensor_type', $sensorType)
            ->where('state', 'ALARM')
            ->where('severity', 'CRITICAL')
            ->first();

        if ($existingLog) {
            // Update existing critical log timestamp
            DB::table('error_logs')
                ->where('id', $existingLog->id)
                ->update([
                    'updated_at' => $now
                ]);
            $this->info("Updated existing CRITICAL log timestamp for sensor {$sensorName}");
        } else {
            // Insert new critical log
            DB::table('error_logs')->insert([
                'sensor_id' => $sensorId,
                'sensor_type' => $sensorType,
                'state' => 'ALARM',
                'threshold' => '>= 50 for 300s',
                'severity' => 'CRITICAL',
                'pic' => 1,
                'assigned_by' => null,
                'desc' => null,
                'status' => 'New',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $this->info("Inserted new CRITICAL log for sensor {$sensorName}");
        }
    }
}