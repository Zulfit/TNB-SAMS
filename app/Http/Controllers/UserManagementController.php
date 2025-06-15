<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'id_staff' => ['required', 'string', 'max:50', 'unique:users,id_staff'],
            'department' => ['required', 'in:Distribution Network Division,Transmission Division'],
            'position' => ['required', 'in:Manager,Staff'],
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

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'id_staff' => $validatedData['id_staff'],
            'department' => $validatedData['department'],
            'position' => $validatedData['position'],
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Default password
        ]);

        if($user->position == 'Staff'){
            $telegramLink = 'https://t.me/+HE_QqRrNfsIzNGVl';
        }else{
            $telegramLink = 'https://t.me/+CstEvaCqXLhiMmNl';
        }
        // dd($user);

        $access= UserManagement::create([
            'user_id' => $user->id,
            'permissions' => $permissions
        ]);

        // dd($access);
        
        Mail::to($user->email)->send(new \App\Mail\NewStaffRegistration($user,$telegramLink));

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
