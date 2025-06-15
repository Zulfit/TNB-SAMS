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
        $this->checkAccessOrAbort('error_log_access');

        $query = ErrorLog::with([
            'sensor.sensor.substation',
            'sensor.sensor.panel',
            'sensor.sensor.compartment',
            'user'
        ]);

        // Restrict to staff if needed
        if (Auth::user()->position == 'Staff') {
            $query->where('pic', Auth::user()->id);
        }

        // Simplified filters
        if ($request->filled('error_id')) {
            $query->where('id', 'like', '%' . $request->error_id . '%');
        }

        if ($request->filled('substation')) {
            $query->whereHasMorph('sensor', [SensorTemperature::class, SensorPartialDischarge::class], function ($q) use ($request) {
                $q->whereHas('sensor.substation', function ($q2) use ($request) {
                    $q2->where('id', $request->substation);
                });
            });
        }
        
        if ($request->filled('panel')) {
            $query->whereHasMorph('sensor', [SensorTemperature::class, SensorPartialDischarge::class], function ($q) use ($request) {
                $q->whereHas('sensor.panel', function ($q2) use ($request) {
                    $q2->where('id', $request->panel);
                });
            });
        }

        if ($request->filled('compartment')) {
            $query->whereHasMorph('sensor', [SensorTemperature::class, SensorPartialDischarge::class], function ($q) use ($request) {
                $q->whereHas('sensor.compartment', function ($q2) use ($request) {
                    $q2->where('id', $request->compartment);
                });
            });
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $errors = $query->orderBy('updated_at', 'desc')->get();

        // Filter options
        $substations = Substation::all();
        $panels = Panels::all();
        $compartments = Compartments::all();
        $states = ['Normal','Warning','Critical'];
        $statuses = ['New', 'Acknowledge', 'Review', 'Quiry', 'Completed'];

        return view('error-log.index', compact(
            'errors',
            'substations',
            'states',
            'statuses',
            'panels',
            'compartments'
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
        // dd($error->sensor->sensor_id);
        $pd = 5;
        if ($error->sensor_type == 'App\Models\SensorTemperature') {
            $datas = SensorTemperature::select('diff_temp', 'created_at')
                ->where('sensor_id', $error->sensor->sensor_id)
                ->whereBetween('created_at', [$error->created_at, now()])
                ->get();
        } elseif ($error->sensor_type == 'App\Models\SensorPartialDischarge') {
            $datas = SensorPartialDischarge::select('indicator', 'created_at')
                ->where('sensor_id', $pd)
                ->whereBetween('created_at', [$error->created_at, now()])
                ->get();
        }
        return view('error-log.create', compact('error', 'staff', 'datas'));
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

            $error = ErrorLog::where('id', $errorLog->id)->first();
            // dd($error->sensor->sensor_id);
            $pd_id = 5;
            if ($error->sensor_type == 'App\Models\SensorTemperature') {
                $temp = SensorTemperature::where('sensor_id', $error->sensor->sensor_id)
                    ->orderBy('updated_at', 'desc')
                    ->first();
            } elseif ($error->sensor_type == 'App\Models\SensorPartialDischarge') {
                $temp = SensorPartialDischarge::where('sensor_id', $pd_id)
                    ->orderBy('updated_at', 'desc')
                    ->first();
            }
            // dd($temp);
            $temp->alert_triggered = 'normal';
            $temp->save();

        } elseif ($request->action === 'review') {
            $validated = $request->validate([
                'report' => 'required|string'
            ]);

            $errorLog->update([
                'status' => 'Review',
                $errorLog->report = $validated['report'],
                $errorLog->completed_at = now()
            ]);

            $error = ErrorLog::where('id', $errorLog->id)->first();
            // dd($error->sensor->sensor_id);
            $pd_id = 5;
            if ($error->sensor_type == 'App\Models\SensorTemperature') {
                $temp = SensorTemperature::where('sensor_id', $error->sensor->sensor_id)
                    ->orderBy('updated_at', 'desc')
                    ->first();
            } elseif ($error->sensor_type == 'App\Models\SensorPartialDischarge') {
                $temp = SensorPartialDischarge::where('sensor_id', $pd_id)
                    ->orderBy('updated_at', 'desc')
                    ->first();
            }
            // dd($temp);
            $temp->alert_triggered = 'normal';
            $temp->save();

        } elseif ($request->action === 'acknowledge') {
            $errorLog->update([
                'status' => 'Acknowledge',
            ]);

            $errorLog->save();

            return redirect()->back()->with('success', 'Error Log acknowledged successfully.');

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

}
