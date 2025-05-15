<?php

namespace App\Http\Controllers;

use App\Models\Compartments;
use App\Models\Panels;
use App\Models\Sensor;
use App\Models\Substation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $substations = Substation::all();
        $panels = Panels::all();
        $compartments = Compartments::all();
        $sensors = Sensor::with('substation')->get();

        return view('sensor.index', compact('substations', 'sensors', 'panels', 'compartments'));
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
        $validated = $request->validate([
            'sensor_name' => 'required|max:255|string',
            'sensor_panel' => 'required|exists:panels,id',
            'sensor_compartment' => 'required|exists:compartments,id',
            'sensor_substation' => 'required|exists:substations,id',
            'sensor_date' => 'required|date',
            'sensor_status' => 'required',
        ]);

        Sensor::create([
            'sensor_name' => $validated['sensor_name'],
            'sensor_panel' => $validated['sensor_panel'],
            'sensor_compartment' => $validated['sensor_compartment'],
            'sensor_substation' => $validated['sensor_substation'],
            'sensor_date' => $validated['sensor_date'],
            'sensor_status' => $validated['sensor_status'],
        ]);

        return redirect()->route('sensor.index')->with('success', 'Sensor created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor $sensor)
    {
        $sensors = Sensor::all();
        return view('sensor.show', compact('sensor', 'sensors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sensor $sensor)
    {
        $sensors = Sensor::all();
        $substations = Substation::all();
        $panels = Panels::all();
        $compartments = Compartments::all();
        return view('sensor.edit', compact('sensor', 'sensors', 'substations', 'panels', 'compartments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sensor $sensor)
    {
        $sensor->sensor_name = $request->sensor_name;
        $sensor->sensor_panel = $request->sensor_panel;
        $sensor->sensor_compartment = $request->sensor_compartment;
        $sensor->sensor_substation = $request->sensor_substation;
        $sensor->sensor_date = $request->sensor_date;
        $sensor->sensor_status = $request->sensor_status;

        $sensor->save();

        return redirect()->route('sensor.index')->with('success', 'Sensor successfully updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor $sensor)
    {
        $sensor->delete();
        return redirect()->route('sensor.index')->with('success', 'Sensor successfully deleted!');
    }

}
