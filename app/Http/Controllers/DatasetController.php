<?php

namespace App\Http\Controllers;

use App\Imports\DatasetImport;
use App\Models\Dataset;
use App\Models\Sensor;
use App\Models\SensorPartialDischarge;
use App\Models\SensorTemperature;
use App\Models\Substation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DatasetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensors = Sensor::all();
        $datasets = Dataset::all();

        return view('dataset.index', compact('sensors', 'datasets'));
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
        $request->validate([
            'dataset_file' => 'required|file|mimes:xlsx,csv',
            'dataset_measurement' => 'required|in:Temperature,Partial Discharge',
            'dataset_sensor' => 'required|exists:sensors,id',
        ]);

        $file = $request->file('dataset_file');
        $path = $file->storeAs('datasets', $file->getClientOriginalName(), 'public');

        // Save to 'datasets' table
        $dataset = Dataset::create([
            'dataset_file' => $file->getClientOriginalName(),
            'dataset_measurement' => $request->dataset_measurement,
            'dataset_sensor' => $request->dataset_sensor,
        ]);

        // Load Excel and insert sensor_temperature rows
        $rows = Excel::toArray(new DatasetImport, $file);

        foreach ($rows[0] as $index => $row) {
            // Skip header
            if ($index === 0) continue;
    
            if ($request->dataset_measurement == 'Temperature') {
                if (count($row) < 9) continue;
    
                SensorTemperature::create([
                    'sensor_id' => $request->dataset_sensor,
                    'red_phase_temp' => $row[1],
                    'yellow_phase_temp' => $row[2],
                    'blue_phase_temp' => $row[3],
                    'max_temp' => $row[4],
                    'min_temp' => $row[5],
                    'variance_percent' => $row[6],
                    'alert_triggered' => $row[7],
                    'created_at' => $row[8],
                    'updated_at' => now(),
                ]);
            }
    
            if ($request->dataset_measurement == 'Partial Discharge') {
                if (count($row) < 15) continue;
    
                SensorPartialDischarge::create([
                    'sensor_id' => $request->dataset_sensor,
                    'LFB_Ratio' => $row[1],
                    'LFB_Ratio_Linear' => $row[2],
                    'MFB_Ratio' => $row[3],
                    'MFB_Ratio_Linear' => $row[4],
                    'HFB_Ratio' => $row[5],
                    'HFB_Ratio_Linear' => $row[6],
                    'Mean_Ratio' => $row[7],
                    'LFB_EPPC' => $row[8],
                    'MFB_EPPC' => $row[9],
                    'HFB_EPPC' => $row[10],
                    'Mean_EPPC' => $row[11],
                    'Indicator' => $row[12],
                    'alert_triggered' => $row[13],
                    'created_at' => $row[14],
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Dataset uploaded and data stored successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dataset $dataset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dataset $dataset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dataset $dataset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dataset $dataset)
    {
        //
    }
}
