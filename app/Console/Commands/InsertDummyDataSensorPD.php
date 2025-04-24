<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertDummyDataSensorPD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:dummy-sensor-pd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert dummy sensor data every 5 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sensorIds = DB::table('sensors')
            ->where('sensor_measurement', 'Partial Discharge')
            ->pluck('id')
            ->toArray();

        $now = now();
        $data = [];

        foreach ($sensorIds as $sensorId) {
            $levelRoll = rand(1, 100);

            if ($levelRoll <= 85) {
                // Normal: 85% of time
                $lfbRatio = 0;
                $mfbRatio = 0;
                $hfbRatio = 0;
                $lfbEPPC = 0;
                $mfbEPPC = 0;
                $hfbEPPC = 0;
            } else {
                // Force values to generate an indicator between 1–3 (Critical)
                $lfbRatio = rand(0, 5);  // dB
                $mfbRatio = rand(0, 5);
                $hfbRatio = rand(0, 5);
                $lfbEPPC = rand(0, 5);
                $mfbEPPC = rand(0, 5);
                $hfbEPPC = rand(0, 5);
            }                

            // Convert ratios to linear
            $lfbLinear = pow(10, $lfbRatio / 10);
            $mfbLinear = pow(10, $mfbRatio / 10);
            $hfbLinear = pow(10, $hfbRatio / 10);

            $meanLinear = ($lfbLinear + $mfbLinear + $hfbLinear) / 3;
            $meanRatio = $meanLinear > 0 ? 10 * log10($meanLinear) : 0;

            $meanEPPC = ($lfbEPPC + $mfbEPPC + $hfbEPPC) / 3;

            $indicator = round($meanRatio * $meanEPPC, 2);

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
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('sensor_partial_discharge')->insert($data);

        $this->info('Inserted dummy data for ' . count($data) . ' sensors at ' . $now);
    }
}
