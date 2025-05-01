<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SensorAlertTriggered;

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
            ->where('sensors.id', 1)
            ->first();

        $now = now();
        $data = [];

        $red = 30.0;
        $yellow = 33.5;
        $blue = 30.2;
        $temps = [$red, $yellow, $blue];
        $max = max($temps);
        $min = min($temps);
        $variance = round(($max - $min) / $max * 100, 2);
        // $variance = 15;

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

        if (in_array($alertLevel, ['warn', 'critical'])) {
            $sensorId = 1; // since hardcoded
            $now = now();
        
            if ($alertLevel === 'warn') {
                // 1. Check if a 'warn' log exists
                $warnLog = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'AWAIT')
                    ->first();
        
                if ($warnLog) {
                    DB::table('error_logs')
                        ->where('id', $warnLog->id)
                        ->update(['updated_at' => $now]);
        
                    $this->info('Updated existing WARN log timestamp.');
                    return;
                }
        
                // 2. If a 'critical' log exists, downgrade to 'warn'
                $criticalLog = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'ALARM')
                    ->first();
        
                if ($criticalLog) {
                    DB::table('error_logs')
                        ->where('id', $criticalLog->id)
                        ->update([
                            'state' => 'AWAIT',
                            'threshold' => '>= 50 for 3600s',
                            'severity' => 'WARN',
                            'updated_at' => $now,
                        ]);
        
                    $this->info('Downgraded CRITICAL to WARN.');
                    return;
                }
        
                // 3. No logs exist — insert new WARN log
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
                return;
        
            } elseif ($alertLevel === 'critical') {
                // Check if warn exists first — upgrade
                $warnLog = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'AWAIT')
                    ->first();
        
                if ($warnLog) {
                    DB::table('error_logs')
                        ->where('id', $warnLog->id)
                        ->update([
                            'state' => 'ALARM',
                            'threshold' => '>= 50 for 300s',
                            'severity' => 'CRITICAL',
                            'updated_at' => $now,
                        ]);
        
                    $this->info('Upgraded WARN to CRITICAL.');
                    return;
                }
        
                // Else update timestamp if critical log already exists
                $criticalLog = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'ALARM')
                    ->first();
        
                if ($criticalLog) {
                    DB::table('error_logs')
                        ->where('id', $criticalLog->id)
                        ->update(['updated_at' => $now]);
        
                    $this->info('Updated existing CRITICAL log timestamp.');
                    return;
                }
        
                // Else insert new critical log
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
                return;
            }

            event(new SensorAlertTriggered($sensor));
            
        }        

        $this->info('Inserted dummy data for ' . count($data) . ' sensors at ' . $now);
    }
}
