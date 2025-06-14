<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use App\Models\Compartments;
use App\Models\ErrorLog;
use App\Models\Panels;
use App\Models\Sensor;
use App\Models\Substation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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

        // Full sensor list (not paginated) — maybe for dropdowns or filters
        $sensorList = Sensor::all();

        return view('analytics', [
            'sensors' => $sensors,           // Paginated list
            'sensorList' => $sensorList,     // Full list
            'substations' => Substation::all(),
            'panels' => Panels::all(),
            'compartments' => Compartments::all(),
        ]);
    }


    public function sensorTable(Request $request)
    {
        $sensorId = $request->input('sensor');
        $parameter = $request->input('parameter'); // 'Temperature' or 'Partial Discharge'
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        $timeRange = max(1, (int) $request->input('time_range'));

        $intervalExpression = "FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at) / ($timeRange * 3600)) * ($timeRange * 3600))";

        if ($parameter === 'Temperature') {
            $data = DB::table('sensor_temperature')
                ->selectRaw("
                sensor_id,
                $intervalExpression as interval_time,
                AVG(red_phase_temp) as avg_red,
                AVG(yellow_phase_temp) as avg_yellow,
                AVG(blue_phase_temp) as avg_blue,
                AVG(max_temp) as avg_max,
                AVG(min_temp) as avg_min,
                AVG(variance_percent) as avg_variance,
                AVG(CASE 
                    WHEN alert_triggered = 'normal' THEN 0
                    WHEN alert_triggered = 'warn' THEN 1
                    WHEN alert_triggered = 'critical' THEN 2
                    ELSE NULL
                END) as avg_alert_level
            ")
                ->where('sensor_id', $sensorId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('interval_time', 'sensor_id')
                ->orderBy('interval_time')
                ->get();
        } else {
            $data = DB::table('sensor_partial_discharge')
                ->selectRaw("
                sensor_id,
                $intervalExpression as interval_time,
                AVG(LFB_Ratio) as avg_lfb,
                AVG(MFB_Ratio) as avg_mfb,
                AVG(HFB_Ratio) as avg_hfb,
                AVG(Mean_Ratio) as avg_mean_ratio,
                AVG(Mean_EPPC) as avg_mean_eppc,
                AVG(Indicator) as avg_indicator,
                AVG(CASE 
                    WHEN alert_triggered = 'normal' THEN 0
                    WHEN alert_triggered = 'critical' THEN 1
                    ELSE NULL
                END) as avg_alert_level
            ")
                ->where('sensor_id', $sensorId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('interval_time', 'sensor_id')
                ->orderBy('interval_time')
                ->get();
        }

        Log::info('Sensor Table Query Data:', ['data' => $data]);
        return response()->json($data);
    }

    public function sensorChartData(Request $request)
    {
        $sensorId = $request->input('sensor');
        $parameter = $request->input('parameter');
        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
        $timeRange = max(1, (int) $request->input('time_range', 1));

        $intervalExpression = "FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at) / ($timeRange * 3600)) * ($timeRange * 3600))";

        if ($parameter === 'Temperature') {
            $data = DB::table('sensor_temperature')
                ->selectRaw("
                sensor_id,
                $intervalExpression as interval_time,
                AVG(red_phase_temp) as avg_red,
                AVG(yellow_phase_temp) as avg_yellow,
                AVG(blue_phase_temp) as avg_blue,
                AVG(max_temp) as avg_max,
                AVG(min_temp) as avg_min,
                AVG(variance_percent) as avg_variance,
                AVG(CASE 
                    WHEN alert_triggered = 'normal' THEN 0
                    WHEN alert_triggered = 'warn' THEN 1
                    WHEN alert_triggered = 'critical' THEN 2
                    ELSE NULL
                END) as avg_alert_level
            ")
                ->where('sensor_id', $sensorId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('interval_time', 'sensor_id')
                ->orderBy('interval_time')
                ->get();
        } else {
            $data = DB::table('sensor_partial_discharge')
                ->selectRaw("
                sensor_id,
                $intervalExpression as interval_time,
                AVG(LFB_Ratio) as avg_lfb,
                AVG(MFB_Ratio) as avg_mfb,
                AVG(HFB_Ratio) as avg_hfb,
                AVG(Mean_Ratio) as avg_mean_ratio,
                AVG(Mean_EPPC) as avg_mean_eppc,
                AVG(Indicator) as avg_indicator,
                AVG(CASE 
                    WHEN alert_triggered = 'normal' THEN 0
                    WHEN alert_triggered = 'critical' THEN 1
                    ELSE NULL
                END) as avg_alert_level
            ")
                ->where('sensor_id', $sensorId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('interval_time', 'sensor_id')
                ->orderBy('interval_time')
                ->get();
        }
        // Log::info('Sensor Table Query Data:', ['data' => $data]);

        return response()->json($data);
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
    public function show($id)
    {
        $sensor = Sensor::with(['substation', 'panel', 'compartment'])->findOrFail($id);

        return response()->json([
            'sensor_name' => $sensor->sensor_name,
            'substation_name' => $sensor->substation->substation_name ?? '',
            'panel_name' => $sensor->panel->panel_name ?? '',
            'compartment_name' => $sensor->compartment->compartment_name ?? '',
            'sensor_measurement' => $sensor->sensor_measurement
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Analytics $analytics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Analytics $analytics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Analytics $analytics)
    {
        //
    }
}
