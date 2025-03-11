<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserManagement;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unverified_users = User::where('email_verified_at', NULL)->get();
        $users = UserManagement::with('user')->get();

        return view('user_management.index', compact('unverified_users', 'users'));
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
            'user_id' => 'required|exists:users,id',
            'dashboard_access' => 'integer',
            'analytics_access' => 'integer',
            'dataset_access' => 'integer',
            'substation_access' => 'integer',
            'asset_access' => 'integer',
            'sensor_access' => 'integer',
            'report_access' => 'integer',
            'user_management_access' => 'integer',
        ]);

        // dd($validated);

        UserManagement::create([
            'user_id' => $validated['user_id'],
            'dashboard_access' => $validated['dashboard_access'] ?? 0,
            'analytics_access' => $validated['analytics_access'] ?? 0,
            'dataset_access' => $validated['dataset_access'] ?? 0,
            'substation_access' => $validated['substation_access'] ?? 0,
            'asset_access' => $validated['asset_access'] ?? 0,
            'sensor_access' => $validated['sensor_access'] ?? 0,
            'report_access' => $validated['report_access'] ?? 0,
            'user_management_access' => $validated['user_management_access'] ?? 0,
        ]);

        User::where('id', $validated['user_id'])->update([
            'email_verified_at' => now()
        ]);

        return redirect()->route('user_management.index')->with('success', 'User permissions updated successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(UserManagement $userManagement)
    {
        // retrieve user that have been clicked
        $user = User::find($userManagement->user_id);
        // retrieve user's access control
        $user_management = $userManagement;
        // retrieve all user that have user access
        $users = UserManagement::with('user')->get();

        return view('user_management.show', compact( 'user','user_management','users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserManagement $userManagement)
    {
        // retrieve user that have been clicked
        $user = User::find($userManagement->user_id);
        // retrieve user's access control
        $user_management = $userManagement;
        // retrieve all user that have user access
        $users = UserManagement::with('user')->get();

        return view('user_management.edit', compact( 'user','user_management','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserManagement $userManagement)
    {
        $userManagement->dashboard_access = $request->dashboard_access;
        $userManagement->analytics_access = $request->analytics_access;
        $userManagement->dataset_access = $request->dataset_access;
        $userManagement->substation_access = $request->substation_access;
        $userManagement->asset_access = $request->asset_access;
        $userManagement->sensor_access = $request->sensor_access;
        $userManagement->report_access = $request->report_access;
        $userManagement->user_management_access = $request->user_management_access;

        $userManagement->save();

        return redirect()->route('user_management.index')->with('success','User access control successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserManagement $userManagement)
    {
        $userManagement->delete();

        User::where('id', $userManagement)->update([
            'email_verified_at' => null
        ]);
    }
}
