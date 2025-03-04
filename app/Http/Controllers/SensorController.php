<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Substation;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $substations = Substation::all();
        $sensors = Sensor::with('substation')->get();

        return view('sensor.index',compact('substations','sensors'));
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
            'sensor_type' => 'required|string',
            'sensor_substation' => 'required|exists:substations,id',
            'sensor_date' => 'required|date',
            'sensor_status' => 'required',
        ]);

        Sensor::create([
            'sensor_name' => $validated['sensor_name'],
            'sensor_type' => $validated['sensor_type'],
            'sensor_substation' => $validated['sensor_substation'],
            'sensor_date' => $validated['sensor_date'],
            'sensor_status' => $validated['sensor_status'],
        ]);

        return redirect()->route('sensor.index')->with('success','Sensor created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor $sensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sensor $sensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sensor $sensor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensor $sensor)
    {
        //
    }
}
