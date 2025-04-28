<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Substation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ErrorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $errors = ErrorLog::with('user')->get();
        return view('error-log.index', compact('errors'));
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
            // Complete the error
            $errorLog->state = 'NORMAL';
            $errorLog->threshold = '>= 50 for 3600s';
            $errorLog->severity = 'SAFE';
        } elseif ($request->input('action') == 'assign') {
            // Assign staff
            $request->validate([
                'pic' => 'required|exists:users,id',
                'desc' => 'nullable|string',
            ]);

            $errorLog->pic = $request->input('pic');
            $errorLog->assigned_by = Auth::user()->id;
            $errorLog->desc = $request->input('desc');
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
