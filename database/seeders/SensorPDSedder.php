<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SensorPDSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startTime = Carbon::create(now()->year, 4, 1)->startOfDay();
        // $endTime = Carbon::create(now()->year, 5, 31)->endOfDay();
        $endTime = now();
        $data = [];

        $sensorIds = DB::table('sensors')
            ->where('sensor_measurement', 'Partial Discharge')
            ->where('sensor_substation', 1)
            ->where('sensor_panel', 1)
            ->where('sensor_status', 'Online')
            ->pluck('id')
            ->toArray();


        while ($startTime <= $endTime) {
            foreach ($sensorIds as $sensorId) {
                $levelRoll = rand(1, 100);

                if ($levelRoll <= 85) {
                    // Normal: 85% of time
                    $lfbRatio = $mfbRatio = $hfbRatio = 0;
                    $lfbEPPC = $mfbEPPC = $hfbEPPC = 0;

                    $lfbLinear = pow(10, $lfbRatio / 10);
                    $mfbLinear = pow(10, $mfbRatio / 10);
                    $hfbLinear = pow(10, $hfbRatio / 10);

                    $meanLinear = ($lfbLinear + $mfbLinear + $hfbLinear) / 3;
                    $meanRatio = $meanLinear > 0 ? 10 * log10($meanLinear) : 0;
                    $meanEPPC = ($lfbEPPC + $mfbEPPC + $hfbEPPC) / 3;

                    $indicator = 0;
                } else {
                    // Force values to generate an indicator between 1–3 (Critical)
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
                }

                if ($indicator == 0) {
                    $alert = 'normal';
                } else {
                    $alert = 'critical';
                }

                $data[] = [
                    'sensor_id' => $sensorId,
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
                    'created_at' => $startTime->copy(),
                    'updated_at' => $startTime->copy(),
                ];
            }

            if (count($data) >= 500) {
                DB::table('sensor_partial_discharge')->insert($data);
                unset($data);
                $data = [];
            }

            $startTime->addMinutes(5);
        }

        // Insert any remaining records
        if (!empty($data)) {
            DB::table('sensor_partial_discharge')->insert($data);
        }
    }
}
