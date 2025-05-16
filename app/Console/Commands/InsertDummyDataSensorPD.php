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
            ->get();

        $now = Carbon::now();
        $data = [];

        foreach ($sensors as $sensor) {
            $levelRoll = rand(1, 100);

            if ($levelRoll <= 85) {
                $lfbRatio = $mfbRatio = $hfbRatio = 0;
                $lfbEPPC = $mfbEPPC = $hfbEPPC = 0;
            } else {
                $lfbRatio = rand(0, 5);
                $mfbRatio = rand(0, 5);
                $hfbRatio = rand(0, 5);
                $lfbEPPC = rand(0, 5);
                $mfbEPPC = rand(0, 5);
                $hfbEPPC = rand(0, 5);
            }

            $lfbLinear = pow(10, $lfbRatio / 10);
            $mfbLinear = pow(10, $mfbRatio / 10);
            $hfbLinear = pow(10, $hfbRatio / 10);

            $meanLinear = ($lfbLinear + $mfbLinear + $hfbLinear) / 3;
            $meanRatio = $meanLinear > 0 ? 10 * log10($meanLinear) : 0;
            $meanEPPC = ($lfbEPPC + $mfbEPPC + $hfbEPPC) / 3;

            $indicator = round($meanRatio * $meanEPPC, 2);

            $alert = $indicator == 0 ? 'normal' : 'critical';

            $data[] = [
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

            if (in_array($alert, ['critical'])) {
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

                // Broadcast event
                event(new \App\Events\SensorAlertTriggered(
                    $sensor->sensor_id, $sensor->sensor_name, $alert
                ));

                // Notify users
                $users = User::whereNotNull('chat_id')->get();
                foreach ($users as $user) {
                    $user->notify(new SensorAlertNotification($alertData, 'Partial Discharge'));
                }

                // Insert into error logs
                DB::table('error_logs')->insert([
                    'sensor_id' => $sensor->sensor_id,
                    'sensor_name' => $sensor->sensor_name,
                    'substation_name' => $sensor->substation_name,
                    'panel_name' => $sensor->panel_name,
                    'compartment_name' => $sensor->compartment_name,
                    'alert_level' => $alert,
                    'indicator' => $indicator,
                    'measurement' => 'Partial Discharge',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (!empty($data)) {
            DB::table('sensor_partial_discharge')->insert($data);
        }

        $this->info('Inserted dummy data for ' . count($data) . ' sensors at ' . $now);
    }
}
