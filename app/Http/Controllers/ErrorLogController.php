<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\User;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $errors = ErrorLog::all();
        return view('error-log.index',compact('errors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staff = User::where('position','Staff')
        ->whereNotNull('email_verified_at')
        ->get();
        return view('error-log.create',compact('staff'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ErrorLog $errorLog)
    {
        //
    }
}
