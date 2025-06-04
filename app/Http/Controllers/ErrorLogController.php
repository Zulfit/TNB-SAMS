<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Compartments;
use App\Models\ErrorLog;
use App\Models\Panels;
use App\Models\Sensor;
use App\Models\SensorPartialDischarge;
use App\Models\SensorTemperature;
use App\Models\Substation;
use App\Models\User;
use App\Notifications\SensorAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ErrorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Base query: load nested relationships (sensor.sensor.substation, etc.)
        $query = ErrorLog::with([
            'sensor.sensor.substation',
            'sensor.sensor.panel',
            'sensor.sensor.compartment',
            'user'
        ]);

        // Filter by user role
        if (Auth::user()->position == 'Staff') {
            $query->where('pic', Auth::user()->id);
        }

        // Filters using nested whereHas for substation/panel/compartment (through sensor.sensor)
        if ($request->filled('substation')) {
            $query->whereHas('sensor.sensor', function ($q) use ($request) {
                $q->where('sensor_substation', $request->substation);
            });
        }

        if ($request->filled('panel')) {
            $query->whereHas('sensor.sensor', function ($q) use ($request) {
                $q->where('sensor_panel', $request->panel);
            });
        }

        if ($request->filled('compartment')) {
            $query->whereHas('sensor.sensor', function ($q) use ($request) {
                $q->where('sensor_compartment', $request->compartment);
            });
        }

        if ($request->filled('measurement')) {
            $query->whereHas('sensor.sensor', function ($q) use ($request) {
                $q->where('sensor_measurement', $request->measurement);
            });
        }

        if ($request->filled('error_id')) {
            $query->where('id', 'like', '%' . $request->error_id . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get the filtered results
        $errors = $query->orderBy('updated_at', 'desc')->get();

        // Get filter options
        $substations = Substation::all();
        $panels = Panels::all();
        $compartments = Compartments::all();

        $measurements = Sensor::distinct()->pluck('sensor_measurement')->filter()->sort()->values();
        $states = ErrorLog::distinct()->pluck('state')->filter()->sort()->values();
        $statuses = ['New', 'Acknowledge', 'Review', 'Quiry', 'Completed'];

        return view('error-log.index', compact(
            'errors',
            'substations',
            'panels',
            'compartments',
            'measurements',
            'states',
            'statuses'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staff = User::where('position', 'Staff')
            ->whereNotNull('email_verified_at')
            ->get();
        $substations = Substation::all();

        return view('error-log.create', compact('staff', 'substations'));
    }

    public function assign(string $id)
    {
        $error = ErrorLog::where('id', $id)->first();
        $staff = User::where('position', 'Staff')
            ->whereNotNull('email_verified_at')
            ->get();
        // dd($error->updated_at);
        if ($error->sensor_type == 'App\Models\SensorTemperature') {
            $datas = SensorTemperature::select('diff_temp','created_at')
                ->where('sensor_id', $error->sensor->sensor_id)
                ->whereBetween('created_at', [$error->created_at, $error->updated_at])
                ->get();
        }elseif ($error->sensor_type == 'App\Models\SensorPartialDischarge') {
            $datas = SensorPartialDischarge::select('indicator','created_at')
                ->where('sensor_id', $error->sensor->sensor_id)
                ->whereBetween('created_at', [$error->created_at, $error->updated_at])
                ->get();
        }
        return view('error-log.create', compact('error', 'staff','datas'));
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
    public function show(ErrorLog $errorLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ErrorLog $errorLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ErrorLog $errorLog)
    {
        // dd($request->all());
        if ($request->input('action') == 'complete') {
            $validated = $request->validate([
                'admin_review' => 'string',
                'sensor_status' => 'string'
            ]);

            $errorLog->state = 'NORMAL';
            $errorLog->threshold = '>= 50 for 3600s';
            $errorLog->severity = 'SAFE';
            $errorLog->status = 'Completed';
            $errorLog->admin_review = $validated['admin_review'];
            $errorLog->reviewed_at = now();

            $sensor = Sensor::find($errorLog->sensor->sensor_id);
            $sensor->sensor_status = $validated['sensor_status'];
            $sensor->save();

        } elseif ($request->action === 'quiry') {
            $validated = $request->validate([
                'admin_review' => 'string',
                'sensor_status' => 'string'
            ]);

            $sensor = Sensor::find($errorLog->sensor->sensor_id);

            $errorLog->status = 'Quiry';
            $errorLog->admin_review = $validated['admin_review'];

            $sensor->sensor_status = $validated['sensor_status'];
            $sensor->save();

        } elseif ($request->action === 'review') {
            $validated = $request->validate([
                'report' => 'required|string'
            ]);

            $errorLog->update([
                'status' => 'Review',
                $errorLog->report = $validated['report'],
                $errorLog->completed_at = now()
            ]);

        } elseif ($request->action === 'acknowledge') {
            $errorLog->update([
                'status' => 'Acknowledge',
            ]);

        } elseif ($request->input('action') == 'assign') {
            // Assign staff
            $request->validate([
                'pic' => 'required|exists:users,id',
                'desc' => 'nullable|string',
            ]);

            $errorLog->pic = $request->input('pic');
            $errorLog->assigned_by = Auth::user()->id;
            $errorLog->desc = $request->input('desc');
            $errorLog->status = 'New';

            $alert = [
                'sensor_name' => $errorLog->sensor->sensor->sensor_name,
                'measurement' => $errorLog->sensor->sensor->sensor_measurement,
                'substation' => $errorLog->sensor->sensor->substation->substation_name,
                'panel' => $errorLog->sensor->sensor->panel->panel_name,
                'compartment' => $errorLog->sensor->sensor->compartment->compartment_name,
                'severity' => $errorLog->severity,
                'error_log_id' => $errorLog->id,
                'pic' => $errorLog->user->name,
            ];

            // Use SensorAlertNotification to send Telegram message
            new SensorAlertNotification($alert, '')->sendAssignMessageAdmin();
            new SensorAlertNotification($alert, '')->sendAssignMessageStaff();
            event(new NotificationEvent(
                'New Error Log Assigned!',
                "Error Log ID: #{$errorLog->id}<br>Sensor Name: {$errorLog->sensor->sensor->sensor_name}<br>PIC: {$errorLog->user->name}"
            ));
        }

        $errorLog->save();

        return redirect()->route('error-log.index')->with('success', 'Error Log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ErrorLog $errorLog)
    {
        //
    }

    public function reviewChart(Request $request)
    {
        $errorId = $request->input('error_id');
        Log::info('Error ID', $errorId);

        // Get the error log with related sensor information
        $error = ErrorLog::with([
            'sensor.sensor.substation',
            'sensor.sensor.panel',
            'sensor.sensor.compartment'
        ])->findOrFail($errorId);

        // Ensure error is completed and has both created_at and updated_at
        if ($error->status !== 'Completed' || !$error->updated_at) {
            return response()->json([
                'error' => 'Error must be completed to generate review chart'
            ], 400);
        }

        $startDate = $error->created_at;
        $endDate = $error->updated_at;
        $sensorId = $error->sensor->sensor->id;
        $measurementType = $error->sensor->sensor->sensor_measurement;

        // Get sensor data based on measurement type
        if (strtolower($measurementType) === 'temperature') {
            // Get temperature data
            $sensorData = SensorTemperature::where('sensor_id', $sensorId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at')
                ->get(['temperature', 'created_at']);

            $chartData = $sensorData->map(function ($data) {
                return [
                    'x' => $data->created_at->format('Y-m-d H:i:s'),
                    'y' => $data->temperature
                ];
            });

            $label = 'Temperature (°C)';
            $color = 'rgba(255, 99, 132, 1)';
            $backgroundColor = 'rgba(255, 99, 132, 0.2)';

        } elseif (strtolower($measurementType) === 'partial discharge') {
            // Get partial discharge data
            $sensorData = SensorPartialDischarge::where('sensor_id', $sensorId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at')
                ->get(['indicator', 'created_at']);

            $chartData = $sensorData->map(function ($data) {
                return [
                    'x' => $data->created_at->format('Y-m-d H:i:s'),
                    'y' => $data->indicator
                ];
            });

            $label = 'Partial Discharge Indicator';
            $color = 'rgba(54, 162, 235, 1)';
            $backgroundColor = 'rgba(54, 162, 235, 0.2)';

        } else {
            return response()->json([
                'error' => 'Unsupported measurement type: ' . $measurementType
            ], 400);
        }

        // Prepare chart configuration
        $chartConfig = [
            'type' => 'line',
            'data' => [
                    'datasets' => [
                        [
                            'label' => $label,
                            'data' => $chartData,
                            'borderColor' => $color,
                            'backgroundColor' => $backgroundColor,
                            'borderWidth' => 2,
                            'fill' => true,
                            'tension' => 0.4,
                            'pointRadius' => 3,
                            'pointHoverRadius' => 6
                        ]
                    ]
                ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                        'title' => [
                            'display' => true,
                            'text' => $error->sensor->sensor->sensor_name . ' - ' . $label . ' Review',
                            'font' => [
                                    'size' => 16,
                                    'weight' => 'bold'
                                ]
                        ],
                        'legend' => [
                            'display' => true,
                            'position' => 'top'
                        ],
                        'tooltip' => [
                            'mode' => 'index',
                            'intersect' => false
                        ]
                    ],
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                                'parser' => 'YYYY-MM-DD HH:mm:ss',
                                'displayFormats' => [
                                        'minute' => 'MMM DD HH:mm',
                                        'hour' => 'MMM DD HH:mm',
                                        'day' => 'MMM DD'
                                    ]
                            ],
                        'title' => [
                            'display' => true,
                            'text' => 'Time'
                        ]
                    ],
                    'y' => [
                        'title' => [
                            'display' => true,
                            'text' => $label
                        ],
                        'beginAtZero' => false
                    ]
                ],
                'interaction' => [
                    'mode' => 'nearest',
                    'axis' => 'x',
                    'intersect' => false
                ]
            ]
        ];

        // Additional metadata
        $metadata = [
            'error_id' => $error->id,
            'sensor_name' => $error->sensor->sensor->sensor_name,
            'location' => $error->sensor->sensor->substation->substation_location,
            'panel' => $error->sensor->sensor->panel->panel_name,
            'compartment' => $error->sensor->sensor->compartment->compartment_name,
            'measurement_type' => $measurementType,
            'severity' => $error->severity,
            'threshold' => $error->threshold,
            'period' => [
                    'start' => $startDate->format('Y-m-d H:i:s'),
                    'end' => $endDate->format('Y-m-d H:i:s'),
                    'duration' => $startDate->diffForHumans($endDate, true)
                ],
            'total_data_points' => $chartData->count()
        ];

        return response()->json([
            'success' => true,
            'chart_config' => $chartConfig,
            'metadata' => $metadata
        ]);
    }
}
