<?php

namespace App\Http\Controllers;

use App\Models\Compartments;
use App\Models\ErrorLog;
use App\Models\Panels;
use App\Models\Report;
use App\Models\Sensor;
use App\Models\SensorPartialDischarge;
use App\Models\SensorTemperature;
use App\Models\Substation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $substations = Substation::all();
        $panels = Panels::all();
        $compartments = Compartments::all();
        $reports = Report::orderBy('created_at', 'desc')->get();
        return view('report.index', compact('substations', 'panels', 'compartments', 'reports'));
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
        $user = Auth::user();

        $request->validate([
            'report_substation' => 'required|exists:substations,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $substation = Substation::findOrFail($request->report_substation);

        // Get related sensors
        $sensors = Sensor::where('sensor_substation', $substation->id)
            ->get();

        $sensorIds = $sensors->pluck('id');

        // --- Temperature Data ---
        $temperatureData = SensorTemperature::whereIn('sensor_id', $sensorIds)
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->with('sensor')
            ->get();

        // Group by sensor_id
        $groupedBySensor = $temperatureData->groupBy('sensor_id');

        // Find highest diff_temp for each sensor
        $maxDiffTempPerSensor = $groupedBySensor->map(function (Collection $records, $sensorId) {
            $maxRecord = $records->sortByDesc('diff_temp')->first();

            return [
                'sensor_id' => $sensorId,
                'sensor_name' => optional($maxRecord->sensor)->sensor_name,
                'max_diff_temp' => $maxRecord->diff_temp,
                'recorded_at' => $maxRecord->created_at->format('Y-m-d H:i:s'),
            ];
        });

        // --- Partial Discharge Data ---
        $pdData = SensorPartialDischarge::whereIn('sensor_id', $sensorIds)
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->with('sensor')
            ->get();

        // Group by sensor_id
        $groupedBySensorPD = $pdData->groupBy('sensor_id');

        // Find highest diff_temp for each sensor
        $maxIndPerSensor = $groupedBySensorPD->map(function (Collection $recordsPD, $sensorId) {
            $maxPD = $recordsPD->sortByDesc('Indicator')->first();

            return [
                'sensor_id' => $sensorId,
                'sensor_name' => optional($maxPD->sensor)->sensor_name,
                'max_indicator' => $maxPD->Indicator,
                'recorded_at' => $maxPD->created_at->format('Y-m-d H:i:s'),
            ];
        });

        // --- Error Log Summary ---
        $errorLogs = ErrorLog::where(function ($query) use ($sensorIds) {
            $query->where('sensor_type', 'App\Models\SensorTemperature')
                ->whereHas('sensor', function ($subQuery) use ($sensorIds) {
                    $subQuery->whereHas('sensor', function ($deepQuery) use ($sensorIds) {
                        $deepQuery->whereIn('sensor_id', $sensorIds);
                    });
                });
        })
        ->orWhere(function ($query) use ($sensorIds) {
            $query->where('sensor_type', 'App\Models\SensorPartialDischarge')
                ->whereHas('sensor', function ($subQuery) use ($sensorIds) {
                    $subQuery->whereHas('sensor', function ($deepQuery) use ($sensorIds) {
                        $deepQuery->whereIn('sensor_id', $sensorIds);
                    });
                });
        })
        ->whereBetween('created_at', [$request->start_date, $request->end_date])
        ->with(['sensor.sensor']) // Load the nested relationships
        ->get();

        // dd($errorLogs);

        $errorStats = $errorLogs->groupBy(function ($error) {
            return $error->sensor_type . '_' . $error->sensor_id; // Group by sensor type + ID
        })->map(function (Collection $errors, $groupKey) {
            $firstError = $errors->first();

            return [
                'sensor_id' => $firstError->sensor_id,
                'sensor_type' => $firstError->sensor_type,
                'sensor_name' => optional($firstError->sensor)->sensor_name,
                'error_count' => $errors->count(),
                'latest_error' => $errors->sortByDesc('created_at')->first()->created_at->format('Y-m-d H:i:s'),
                'severity_levels' => $errors->pluck('severity')->unique()->values()->toArray(),
                'states' => $errors->pluck('state')->unique()->values()->toArray(),
                'status_breakdown' => $errors->countBy('status')->all()
            ];
        });
        // dd($errorStats);

        // Store data or generate view
        $pdf = PDF::loadView('report.template', [
            'substation' => $substation,
            'sensors' => $sensors,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'maxDiffTempPerSensor' => $maxDiffTempPerSensor,
            'maxIndPerSensor' => $maxIndPerSensor,
            'errorStats' => $errorStats,
            'generated_by' => $user->name,
            'generated_at' => now()
        ]);
        // dd($pdf);

        $filename = 'report_' . uniqid() . '.pdf';
        $path = 'public/reports/' . $filename;
        Storage::put($path, $pdf->output());

        Report::create([
            'report_substation' => $substation->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'generated_by' => $user->id,
            'file_report' => 'reports/' . $filename,
        ]);

        return redirect()->back()->with('success', 'Report generated successfully.');
    }

    public function download($id)
    {
        $report = Report::findOrFail($id);

        if (!Storage::exists('public/' . $report->file_report)) {
            abort(404, 'File not found.');
        }

        return Storage::download('public/' . $report->file_report);
    }


    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('report.index')->with('success', 'Report successfully deleted!');
    }
}
