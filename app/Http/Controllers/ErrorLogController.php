<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Substation;
use App\Models\User;
use Illuminate\Http\Request;

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
        $request->validate([
            'pic' => 'required|exists:users,id',
            'desc' => 'nullable|string',
        ]);

        // Update the fields
        $errorLog->pic = $request->input('pic'); // or assign to a more meaningful field name
        $errorLog->desc = $request->input('desc');
        $errorLog->save();

        return redirect()->back()->with('success', 'Error Log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ErrorLog $errorLog)
    {
        //
    }
}
