<?php

namespace App\Http\Controllers;

use App\Models\Compartments;
use App\Models\Panels;
use App\Models\Report;
use App\Models\Substation;
use Illuminate\Http\Request;

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
        $reports = Report::all();
        return view('report.index',compact('substations','panels','compartments','reports'));
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
        $validated = $request->validate([
            'report_substation' => 'required| exists:substations,id',
            'report_panel' => 'required| exists:panels,id',
            'report_compartment' => 'required| exists:compartments,id',
            'start_date' => 'required| date',
            'end_date' => 'required|date',
        ]);

        Report::create([
            'report_substation' => $validated['report_substation'],
            'report_panel' => $validated['report_panel'],
            'report_compartment' => $validated['report_compartment'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()->route('report.index')->with('success','Report successfully generated!');
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
        //
    }
}
