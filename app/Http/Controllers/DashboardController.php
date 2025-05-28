<?php

namespace App\Http\Controllers;

use App\Models\Compartments;
use App\Models\ErrorLog;
use App\Models\Panels;
use App\Models\Sensor;
use App\Models\SensorTemperature;
use App\Models\Substation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $substations = Substation::all();
        $panels = Panels::all();
        $compartments = Compartments::all();
        $sensor_temps = Sensor::where('sensor_measurement', 'Temperature')->get();

        // Get year and month from request, default to current year/month
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        // Calculate totals - some filtered by year, some not
        $total_substation = Substation::count();
        $total_sensor = Sensor::where('sensor_status', 'Active')->count();

        // Build query for failures based on filters
        $failureQuery = ErrorLog::query();
        $warningQuery = ErrorLog::where('severity', 'warn');
        $criticalQuery = ErrorLog::where('severity', 'critical');
        $resolvedQuery = ErrorLog::where('status', 'Completed');
        $reviewQuery = ErrorLog::where('status', 'Reviewed');
        $quiryQuery = ErrorLog::where('status', 'Quiry');

        // Apply year filter
        if ($year) {
            $failureQuery->whereYear('created_at', $year);
            $warningQuery->whereYear('created_at', $year);
            $criticalQuery->whereYear('created_at', $year);
            $resolvedQuery->whereYear('created_at', $year);
            $reviewQuery->whereYear('created_at', $year);
            $quiryQuery->whereYear('created_at', $year);
        }

        // Apply month filter if provided
        if ($month && $month !== '') {
            $failureQuery->whereMonth('created_at', $month);
            $warningQuery->whereMonth('created_at', $month);
            $criticalQuery->whereMonth('created_at', $month);
            $resolvedQuery->whereMonth('created_at', $month);
            $reviewQuery->whereMonth('created_at', $month);
            $quiryQuery->whereMonth('created_at', $month);
        }

        $total_failure = $failureQuery->count();
        $total_warning = $warningQuery->count();
        $total_critical = $criticalQuery->count();
        $total_resolved = $resolvedQuery->count();
        $total_review = $reviewQuery->count();
        $total_query = $quiryQuery->count();

        return view('dashboard', compact(
            'substations',
            'panels',
            'compartments',
            'total_substation',
            'total_sensor',
            'sensor_temps',
            'total_failure',
            'total_warning',
            'total_critical',
            'total_resolved',
            'total_review',
            'total_query',
            'year',
            'month'
        ));
    }

    public function getStatsByPeriod(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month');
        $timeGap = $request->input('timeGap', 'daily');

        // Build queries
        $failureQuery = ErrorLog::query();
        $warningQuery = ErrorLog::where('severity', 'warn');
        $criticalQuery = ErrorLog::where('severity', 'critical');
        $resolvedQuery = ErrorLog::where('status', 'Completed');
        $reviewQuery = ErrorLog::where('status', 'Reviewed');
        $quiryQuery = ErrorLog::where('status', 'Quiry');

        // Apply year filter
        if ($year) {
            $failureQuery->whereYear('created_at', $year);
            $warningQuery->whereYear('created_at', $year);
            $criticalQuery->whereYear('created_at', $year);
            $resolvedQuery->whereYear('created_at', $year);
            $reviewQuery->whereYear('created_at', $year);
            $quiryQuery->whereYear('created_at', $year);
        }

        // Apply month filter if provided
        if ($month && $month !== '') {
            $failureQuery->whereMonth('created_at', $month);
            $warningQuery->whereMonth('created_at', $month);
            $criticalQuery->whereMonth('created_at', $month);
            $resolvedQuery->whereMonth('created_at', $month);
            $reviewQuery->whereMonth('created_at', $month);
            $quiryQuery->whereMonth('created_at', $month);
        }

        $stats = [
            'total_substation' => Substation::count(),
            'total_sensor' => Sensor::count(),
            'total_failure' => $failureQuery->count(),
            'total_warning' => $warningQuery->count(),
            'total_critical' => $criticalQuery->count(),
            'total_resolved' => $resolvedQuery->count(),
            'total_review' => $reviewQuery->count(),
            'total_query' => $quiryQuery->count(),
            'year' => $year,
            'month' => $month,
            'timeGap' => $timeGap
        ];

        return response()->json($stats);
    }

    public function getSensorTemperature(Request $request)
    {
        try {
            $substationId = $request->input('substation');
            $panelId = $request->input('panel');
            $compartmentId = $request->input('compartment');
            $year = $request->input('year', date('Y'));
            $month = $request->input('month');
            $timeGap = $request->input('timeGap', 'daily');

            // Find the sensor
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

            // Build the query for temperature data
            $query = DB::table('sensor_temperature')
                ->join('sensors', 'sensor_temperature.sensor_id', '=', 'sensors.id')
                ->select(
                    'sensor_temperature.sensor_id',
                    'sensor_temperature.created_at',
                    'sensor_temperature.red_phase_temp as Red_Phase',
                    'sensor_temperature.yellow_phase_temp as Yellow_Phase',
                    'sensor_temperature.blue_phase_temp as Blue_Phase',
                    'sensor_temperature.max_temp',
                    'sensor_temperature.min_temp',
                    'sensor_temperature.variance_percent',
                    'sensor_temperature.alert_triggered'
                )
                ->where('sensors.sensor_substation', $substationId)
                ->where('sensors.sensor_panel', $panelId)
                ->where('sensors.sensor_compartment', $compartmentId);

            // Apply time filters
            if ($year) {
                $query->whereYear('sensor_temperature.created_at', $year);
            }

            if ($month && $month !== '') {
                $query->whereMonth('sensor_temperature.created_at', $month);
            }

            // Apply time gap grouping
            switch ($timeGap) {
                case '5min':
                    // Every 5 minutes — just get the latest 288 records (1 day's worth)
                    $query->orderBy('sensor_temperature.created_at', 'desc')
                        ->limit(30);
                    break;

                case '10min':
                    // Every 10 minutes — get one out of every two 5-minute readings
                    $query->whereRaw('MOD(MINUTE(sensor_temperature.created_at), 10) = 0')
                        ->orderBy('sensor_temperature.created_at', 'desc')
                        ->limit(30);
                    break;

                case '30min':
                    // Every 30 minutes
                    $query->whereRaw('MOD(MINUTE(sensor_temperature.created_at), 30) = 0')
                        ->orderBy('sensor_temperature.created_at', 'desc')
                        ->limit(30);
                    break;

                case 'hourly':
                    // Every hour
                    $query->whereRaw('MINUTE(sensor_temperature.created_at) = 0')
                        ->orderBy('sensor_temperature.created_at', 'desc')
                        ->limit(24);
                    break;

                default:
                    // Default to every 5 minutes
                    $query->orderBy('sensor_temperature.created_at', 'desc')
                        ->limit(30);
            }

            $data = $query->get();

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
            $year = $request->input('year', date('Y'));
            $month = $request->input('month');
            $timeGap = $request->input('timeGap', 'daily');

            // Build the query for partial discharge data
            $query = DB::table('sensor_partial_discharge')
                ->join('sensors', 'sensor_partial_discharge.sensor_id', '=', 'sensors.id')
                ->select(
                    'sensor_partial_discharge.created_at',
                    'sensor_partial_discharge.Indicator',
                    'sensor_partial_discharge.Mean_Ratio',
                    'sensor_partial_discharge.Mean_EPPC'
                )
                ->where('sensors.sensor_substation', $substationId)
                ->where('sensors.sensor_panel', $panelId)
                ->where('sensors.sensor_compartment', $compartmentId);

            // Apply time filters
            if ($year) {
                $query->whereYear('sensor_partial_discharge.created_at', $year);
            }

            if ($month && $month !== '') {
                $query->whereMonth('sensor_partial_discharge.created_at', $month);
            }

            // Apply time gap grouping
            switch ($timeGap) {
                case '5min':
                    // Every 5 minutes — just get the latest 288 records (1 day's worth)
                    $query->orderBy('sensor_partial_discharge.created_at', 'desc')
                        ->limit(30);
                    break;

                case '10min':
                    // Every 10 minutes — get one out of every two 5-minute readings
                    $query->whereRaw('MOD(MINUTE(sensor_partial_discharge.created_at), 10) = 0')
                        ->orderBy('sensor_partial_discharge.created_at', 'desc')
                        ->limit(30);
                    break;

                case '30min':
                    // Every 30 minutes
                    $query->whereRaw('MOD(MINUTE(sensor_partial_discharge.created_at), 30) = 0')
                        ->orderBy('sensor_partial_discharge.created_at', 'desc')
                        ->limit(30);
                    break;

                case 'hourly':
                    // Every hour
                    $query->whereRaw('MINUTE(sensor_partial_discharge.created_at) = 0')
                        ->orderBy('sensor_partial_discharge.created_at', 'desc')
                        ->limit(24);
                    break;

                default:
                    // Default to every 5 minutes
                    $query->orderBy('sensor_partial_discharge.created_at', 'desc')
                        ->limit(30);
            }

            $data = $query->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // New methods required by the blade file
    public function getPanelsBySubstation($substationId)
    {
        try {
            $panels = Panels::where('substation_id', $substationId)->get();
            return response()->json($panels);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getCompartmentsByPanel($panelId)
    {
        try {
            $compartments = Compartments::where('panel_id', $panelId)->get();
            return response()->json($compartments);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
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

}
