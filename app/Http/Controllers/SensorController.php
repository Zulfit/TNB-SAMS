<?php

namespace App\Http\Controllers;

use App\Models\Compartments;
use App\Models\Panels;
use App\Models\Sensor;
use App\Models\Substation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkAccessOrAbort('sensor_access');

        $sensors = Sensor::query()
            ->when($request->substation, fn($q) => $q->where('sensor_substation', $request->substation))
            ->when($request->panel, fn($q) => $q->where('sensor_panel', $request->panel))
            ->when($request->compartment, fn($q) => $q->where('sensor_compartment', $request->compartment))
            ->when($request->measurement, fn($q) => $q->where('sensor_measurement', $request->measurement))
            ->when($request->status, fn($q) => $q->where('sensor_status', $request->status))
            ->with(['substation', 'panel', 'compartment'])
            ->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();


        return view('sensor.index', [
            'sensors' => $sensors,        
            'substations' => Substation::all(),
            'panels' => Panels::all(),
            'compartments' => Compartments::all(),
        ]);
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
            'sensor_date' => 'required|date|before_or_equal:today',
            'sensor_measurement' => 'required',
            'sensor_status' => 'required',
        ]);

        $exists = Sensor::where('sensor_name', $request->sensor_name)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'custom_popup' => 'A sensor name have been used.'
            ]);
        }

        Sensor::create([
            'sensor_name' => $validated['sensor_name'],
            'sensor_panel' => $validated['sensor_panel'],
            'sensor_compartment' => $validated['sensor_compartment'],
            'sensor_substation' => $validated['sensor_substation'],
            'sensor_measurement' => $validated['sensor_measurement'],
            'sensor_date' => $validated['sensor_date'],
            'sensor_status' => $validated['sensor_status'],
        ]);

        return redirect()->route('sensor.index')->with('success', 'Sensor created successfully!');
    }

    public function bulkCreate()
    {
        $substations = Substation::all(); // Adjust model name
        $panels = Panels::all(); // Adjust model name
        $compartments = Compartments::all(); // Adjust model name
        $sensors = Sensor::with(['substation', 'panel', 'compartment'])->paginate(10);

        return view('sensor.bulk-create', compact('substations', 'panels', 'compartments', 'sensors'));
    }

    /**
     * Store bulk sensors
     */
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'substation_id' => 'required|exists:substations,id',
            'installation_date' => 'required|date',
            'sensors' => 'required|array|min:1',
            'sensors.*.name' => 'required|string|max:255',
            'sensors.*.panel_id' => 'required|exists:panels,id',
            'sensors.*.measurement' => 'required|in:Temperature,Partial Discharge',
            'sensors.*.status' => 'required|in:Online,Offline',
            'sensors.*.compartments' => 'required|array|min:1', // must have at least one compartment
            'sensors.*.compartments.*' => 'exists:compartments,id',
        ]);

        foreach ($validated['sensors'] as $sensorData) {
            $index = 1;

            foreach ($sensorData['compartments'] as $compartmentId) {
                // 001, 002, ...
                $indexPadded = str_pad($index, 3, '0', STR_PAD_LEFT);

                // e.g. TBHN-sensor-001
                $sensorName = $sensorData['name'] . '_' . $indexPadded;

                $exists = Sensor::where('sensor_name', $request->sensor_name)
                    ->exists();

                if ($exists) {
                    return back()->withErrors([
                        'custom_popup' => 'A sensor name have been used.'
                    ]);
                }

                Sensor::create([
                    'sensor_name' => $sensorName,
                    'sensor_panel' => $sensorData['panel_id'],
                    'sensor_compartment' => $compartmentId,
                    'sensor_substation' => $validated['substation_id'],
                    'sensor_measurement' => $sensorData['measurement'],
                    'sensor_date' => $validated['installation_date'],
                    'sensor_status' => $sensorData['status'],
                ]);

                $index++;
            }
        }

        return redirect()->route('sensor.index')->with('success', 'Bulk sensors created for each compartment!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Sensor $sensor)
    {
        $sensors = Sensor::with(['substation', 'panel', 'compartment'])->paginate(10);
        return view('sensor.show', compact('sensor', 'sensors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sensor $sensor)
    {
        $sensors = Sensor::with(['substation', 'panel', 'compartment'])->paginate(10);
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
        $validated = $request->validate([
            'sensor_name' => 'required|max:255|string',
            'sensor_panel' => 'required|exists:panels,id',
            'sensor_compartment' => 'required|exists:compartments,id',
            'sensor_substation' => 'required|exists:substations,id',
            'sensor_measurement' => 'required',
            'sensor_date' => 'required|date|before_or_equal:today',
            'sensor_status' => 'required',
        ]);

        $sensor->sensor_name = $request->sensor_name;
        $sensor->sensor_panel = $request->sensor_panel;
        $sensor->sensor_compartment = $request->sensor_compartment;
        $sensor->sensor_substation = $request->sensor_substation;
        $sensor->sensor_measurement = $request->sensor_measurement;
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
