<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertDummyWarnData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:dummy-warn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert dummy warn sensor data';

    /**
     * Execute the console command.
     */
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
            ->where('sensors.id',1)
            ->first();

        $now = now();
        $data = [];

            $red = 30.0;
            $yellow = 33.5;
            $blue = 30.2;
            $temps = [$red, $yellow, $blue];
            $max = max($temps);
            $min = min($temps);
            $variance = round(($max - $min) / $max * 100,2);

            $alertLevel = match (true) {
                $variance >= 12 => 'critical',
                $variance >= 10 => 'warn',
                default => 'normal',
            };

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
                    'variance_percent' => round($variance, 2),
                ];
            }

            $data[] = [
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
            ];
        

        DB::table('sensor_temperature')->insert($data);

        if ($alertsToNotify) {
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
