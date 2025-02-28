<?php

namespace App\Http\Controllers;

use App\Models\Substation;
use Illuminate\Http\Request;

class SubstationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $substations = Substation::all();

        return view('substation.index',compact('substations'));
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
            'substation_name' => 'required|max:255| string',
            'substation_location' => 'required|max:255| string',
            'substation_date' => 'required|date',
        ]);

        Substation::create([
            'substation_name' => $validated['substation_name'],
            'substation_location' => $validated['substation_location'],
            'substation_date' => $validated['substation_date'],
        ]);

        return redirect()->route('substation.index')->with('success','Substation created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Substation $substation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Substation $substation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Substation $substation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Substation $substation)
    {
        $substation->delete();
        return redirect()->route('substation.index')->with('success','Substation successfully deleted!');
    }
}
