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
        // dd($substation->id);
    
        // Get related sensors
        $sensors = Sensor::where('sensor_substation', $substation->id)
            ->get();

        // dd($sensors);
    
        $sensorIds = $sensors->pluck('id');
        // dd($sensorIds);
    
        // --- Temperature Data ---
        $temperatureData = SensorTemperature::whereIn('sensor_id', $sensorIds)
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get();
            // dd($temperatureData);
    
        $tempStats = [
            'average_red' => round($temperatureData->avg('red_phase_temp'), 2),
            'average_yellow' => round($temperatureData->avg('yellow_phase_temp'), 2),
            'average_blue' => round($temperatureData->avg('blue_phase_temp'), 2),
            'max_temp' => $temperatureData->max('max_temp'),
            'min_temp' => $temperatureData->min('min_temp'),
            'variance_avg' => round($temperatureData->avg('variance_percent'), 2),
            'alerts' => $temperatureData->groupBy('alert_triggered')->map->count(),
        ];
    
        // --- Partial Discharge Data ---
        $pdData = SensorPartialDischarge::whereIn('sensor_id', $sensorIds)
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get();
    
        $pdStats = [
            'avg_mean_ratio' => round($pdData->avg('Mean_Ratio'), 2),
            'avg_indicator' => round($pdData->avg('Indicator'), 2),
            'alerts' => $pdData->groupBy('alert_triggered')->map->count(),
        ];
    
        // --- Error Log Summary ---
        $errorLogs = ErrorLog::whereIn('sensor_id', $sensorIds)
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get();
            // dd($errorLogs);
    
        $errorStats = [
            'total' => $errorLogs->count(),
            'by_state' => $errorLogs->groupBy('state')->map->count(),
            'by_severity' => $errorLogs->groupBy('severity')->map->count(),
        ];
        // dd($errorStats);
    
        // Store data or generate view
        $pdf = PDF::loadView('report.template', [
            'substation' => $substation,
            'sensors' => $sensors,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'tempStats' => $tempStats,
            'pdStats' => $pdStats,
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
