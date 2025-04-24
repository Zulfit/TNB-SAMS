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

            $data = DB::table('sensor_temperature')
                ->join('sensors', 'sensor_temperature.sensor_id', '=', 'sensors.id')
                ->select(
                    'sensor_temperature.created_at',
                    'sensor_temperature.red_phase_temp',
                    'sensor_temperature.yellow_phase_temp',
                    'sensor_temperature.blue_phase_temp',
                    'sensor_temperature.max_temp',
                    'sensor_temperature.min_temp',
                    'sensor_temperature.variance_percent'
                )
                ->where('sensors.sensor_substation', $substationId)
                ->where('sensors.sensor_panel', $panelId)
                ->where('sensors.sensor_compartment', $compartmentId)
                ->orderBy('sensor_temperature.created_at', 'desc')
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


}
