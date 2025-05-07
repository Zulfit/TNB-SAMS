<?php

namespace App\Http\Controllers;

use App\Models\Compartments;
use App\Models\Panels;
use App\Models\Sensor;
use App\Models\Substation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $substations = Substation::all();
        $panels = Panels::all();
        $compartments = Compartments::all();
        $total_substation = Substation::count();
        $total_sensor = Sensor::count();
        $sensor_temps = Sensor::where('sensor_measurement', 'Temperature')->get();
        // dd($sensor_temps->substation);

        return view('dashboard', compact('substations', 'panels', 'compartments', 'total_substation', 'total_sensor', 'sensor_temps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getSensorTemperature(Request $request)
    {
        try {
            $substationId = $request->input('substation');
            $panelId = $request->input('panel');
            $compartmentId = $request->input('compartment');

            $sensor = DB::table('sensors')
                ->where('sensor_substation', $substationId)
                ->where('sensor_panel', $panelId)
                ->where('sensor_compartment', $compartmentId)
                ->where('sensor_measurement', 'Temperature')
                ->first();

            if (!$sensor) {
                return response()->json([
                    'error' => true,
                    'message' => 'Sensor not found.'
                ], 404);
            }

            $data = DB::table('sensor_temperature')
                ->join('sensors', 'sensor_temperature.sensor_id', '=', 'sensors.id')
                ->select(
                    'sensor_temperature.sensor_id',
                    'sensor_temperature.created_at',
                    'sensor_temperature.red_phase_temp',
                    'sensor_temperature.yellow_phase_temp',
                    'sensor_temperature.blue_phase_temp',
                    'sensor_temperature.max_temp',
                    'sensor_temperature.min_temp',
                    'sensor_temperature.variance_percent',
                    'sensor_temperature.alert_triggered'
                )
                ->where('sensors.sensor_substation', $substationId)
                ->where('sensors.sensor_panel', $panelId)
                ->where('sensors.sensor_compartment', $compartmentId)
                ->orderBy('sensor_temperature.created_at', 'desc')
                ->limit(7)
                ->get();

            return response()->json([
                'sensor_id' => $sensor->id,
                'sensor_name' => $sensor->sensor_name ?? 'Sensor ' . $sensor->id,
                'readings' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSensorPartialDischarge(Request $request)
    {
        try {
            $substationId = $request->input('substation');
            $panelId = $request->input('panel');
            $compartmentId = $request->input('compartment');

            $data = DB::table('sensor_partial_discharge')
                ->join('sensors', 'sensor_partial_discharge.sensor_id', '=', 'sensors.id')
                ->select(
                    'sensor_partial_discharge.created_at',
                    'sensor_partial_discharge.Indicator',
                    'sensor_partial_discharge.Mean_Ratio',
                    'sensor_partial_discharge.Mean_EPPC'
                )
                ->where('sensors.sensor_substation', $substationId)
                ->where('sensors.sensor_panel', $panelId)
                ->where('sensors.sensor_compartment', $compartmentId)
                ->orderBy('sensor_partial_discharge.created_at', 'desc')
                ->limit(7)
                ->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logError(Request $request)
    {
        try {
            $sensorId = $request->input('sensorId');
            $alertTriggered = $request->input('alertTriggered');

            session()->put('alert', [
                'type' => $alertTriggered,      
                'sensorId' => $sensorId
            ]);

            if ($alertTriggered === 'warn') {
                $state = 'AWAIT';
                $threshold = '>= 50 for 3600s';
                $severity = 'WARN';

                // Check if a warning is already logged for this sensor
                $existing = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'AWAIT')
                    ->exists();

                if ($existing) {
                    return response()->json(['message' => 'Warning already logged.'], 200);
                }

            } elseif ($alertTriggered === 'critical') {
                $state = 'ALARM';
                $threshold = '>= 50 for 300s';
                $severity = 'CRITICAL';

                // Check if a critical log already exists for this sensor
                $existingCritical = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'ALARM')  // Checking for an existing "ALARM" state
                    ->exists();

                if ($existingCritical) {
                    return response()->json(['message' => 'Critical alert already logged.'], 200);
                }

                // Try to update an existing warning log first
                $updated = DB::table('error_logs')
                    ->where('sensor_id', $sensorId)
                    ->where('state', 'AWAIT')
                    ->update([
                        'state' => $state,
                        'threshold' => $threshold,
                        'severity' => $severity,
                        'updated_at' => now(),
                    ]);

                if ($updated) {
                    return response()->json(['message' => 'Updated to critical.'], 200);
                }

            } else {
                return response()->json(['message' => 'Invalid alertTriggered value.'], 400);
            }

            // Insert a new log (either a new warn or critical)
            DB::table('error_logs')->insert([
                'sensor_id' => $sensorId,
                'state' => $state,
                'threshold' => $threshold,
                'severity' => $severity,
                'pic' => 1,
                'assigned_by' => null,
                'desc' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }








}
