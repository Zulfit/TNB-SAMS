<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    /**
     * Screen permission required before every action on this controller.
     * Null leaves the existing check unused (login is enforced on the route).
     */
    protected ?string $modulePermission = null;

    /**
     * Run the same screen-permission check index already used, then the action.
     * create, show, edit, update, destroy and custom endpoints are covered too.
     *
     * @param  string  $method
     * @param  array<string, mixed>  $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if (is_string($this->modulePermission) && $this->modulePermission !== '') {
            $this->checkAccessOrAbort($this->modulePermission);
        }

        return $this->{$method}(...array_values($parameters));
    }

    protected function checkAccessOrAbort(string $key, string $required = 'full')
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'Unauthorized access.');
        }

        $userPermission = \App\Models\UserManagement::where('user_id', $user->id)->first();

        $permissions = $userPermission?->permissions ?? [];

        if (! isset($permissions[$key]) || ! array_intersect(['full', 'view', 'create', 'edit', 'delete'], (array) $permissions[$key])) {
            abort(403, 'Unauthorized access.');
        }
    }
}
