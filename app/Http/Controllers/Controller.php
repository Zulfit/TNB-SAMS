<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function checkAccessOrAbort(string $key, string $required = 'full')
    {
        $user = Auth::user();
        $userPermission = \App\Models\UserManagement::where('user_id', $user->id)->first();

        $permissions = $userPermission?->permissions ?? [];

        if (!isset($permissions[$key]) || !array_intersect(['full', 'view', 'create', 'edit', 'delete'], $permissions[$key])) {
            abort(403, 'Unauthorized access.');
        }
    }


}
