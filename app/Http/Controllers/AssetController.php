<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Substation;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $substations = Substation::all();
        $assets = Asset::with('substation')->get();
        return view('asset.index',compact('substations','assets'));
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
            'asset_name' => 'required|max:255|string',
            'asset_type' => 'required|string',
            'asset_substation' => 'required|exists:substations,id',
            'asset_date' => 'required|date',
            'asset_status' => 'required|string',
        ]);
        // dd($validated);
        Asset::create([
            'asset_name' => $validated['asset_name'],
            'asset_type' => $validated['asset_type'],
            'asset_substation' => $validated['asset_substation'],
            'asset_date' => $validated['asset_date'],
            'asset_status' => $validated['asset_status']
        ]);

        return redirect()->route('asset.index')->with('success','Asset created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->to('asset.index')->with('success','Asset successfully deleted!');
    }
}
