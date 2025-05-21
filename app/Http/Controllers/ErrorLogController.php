<?php

namespace App\Http\Controllers;

use App\Models\Compartments;
use App\Models\ErrorLog;
use App\Models\Panels;
use App\Models\Sensor;
use App\Models\Substation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ErrorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $errors = ErrorLog::with(['user', 'sensor.substation', 'sensor.panel', 'sensor.compartment'])
            ->when(
                $request->substation,
                fn($q) =>
                $q->whereHas(
                    'sensor',
                    fn($q2) =>
                    $q2->where('sensor_substation', $request->substation)
                )
            )
            ->when(
                $request->panel,
                fn($q) =>
                $q->whereHas(
                    'sensor',
                    fn($q2) =>
                    $q2->where('sensor_panel', $request->panel)
                )
            )
            ->when(
                $request->compartment,
                fn($q) =>
                $q->whereHas(
                    'sensor',
                    fn($q2) =>
                    $q2->where('sensor_compartment', $request->compartment)
                )
            )
            ->when(
                $request->measurement,
                fn($q) =>
                $q->whereHas(
                    'sensor',
                    fn($q2) =>
                    $q2->where('sensor_measurement', $request->measurement)
                )
            )
            ->when($request->state, fn($q) => $q->where('state', $request->state))

            // 👉 Restrict to only own errors if position is Staff
            ->when(
                $user->position === 'Staff',
                fn($q) => $q->where('pic', $user->id)
            )

            ->orderByDesc('updated_at')
            ->get();

        return view('error-log.index', [
            'errors' => $errors,
            'substations' => Substation::all(),
            'panels' => Panels::all(),
            'compartments' => Compartments::all(),
            'measurements' => Sensor::distinct()->pluck('sensor_measurement'),
            'states' => ErrorLog::distinct()->pluck('state'),
            'user'
        ]);
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
        return view('error-log.create', compact('error', 'staff'));
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
        if ($request->input('action') == 'complete') {
            $validated = $request->validate([
                'report' => 'required|string'
            ]);

            $errorLog->state = 'NORMAL';
            $errorLog->threshold = '>= 50 for 3600s';
            $errorLog->severity = 'SAFE';
            $errorLog->report = $validated['report'];
            $errorLog->status = 'Completed';

        } elseif ($request->action === 'acknowledge') {
            $errorLog->update([
                'status' => 'Acknowledged',
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
