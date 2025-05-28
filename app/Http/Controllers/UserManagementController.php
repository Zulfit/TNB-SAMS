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
        // Validate request
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Define all your screens
        $screens = [
            'dashboard',
            'analytics',
            'dataset',
            'substation',
            'asset',
            'sensor',
            'report',
            'user_management'
        ];

        $permissions = [];

        // Loop through each screen and collect permissions
        foreach ($screens as $screen) {
            $key = $screen . '_access';
            $permissions[$screen] = $request->input($key, []);
        }

        // Store in DB
        UserManagement::updateOrCreate(
            ['user_id' => $request->user_id],
            ['permissions' => $permissions]
        );

        $staff = User::find($request->user_id);
        $staff->email_verified_at = now();
        $staff->save();

        return redirect()->back()->with('success', 'User verified successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserManagement $userManagement)
    {
        $user = User::find($userManagement->user_id);
        $userPermission = UserManagement::where('user_id', $userManagement->user_id)->first();

        $permissions = $userPermission ? $userPermission->permissions : [];

        $users = UserManagement::with('user')->get();
        // dd($permissions);

        return view('user_management.show', compact('user', 'permissions', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserManagement $userManagement)
    {
        $user = User::find($userManagement->user_id);
        $userPermission = UserManagement::where('user_id', $userManagement->user_id)->first();

        $permissions = $userPermission ? $userPermission->permissions : [];
        $users = UserManagement::with('user')->get();


        return view('user_management.edit', compact('user', 'permissions', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {
        $permissionId = UserManagement::where('user_id', $userId)->first();
        $userManagement = UserManagement::findOrFail($permissionId->id);

        $validated = $request->validate([
            'permissions' => 'required|array',
        ]);
        // dd($validated['permissions']);

        $userManagement->update([
            'permissions' => $validated['permissions'],
        ]);

        return redirect()->back()->with('success', 'Permissions updated.');
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
