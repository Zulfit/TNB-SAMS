<?php

namespace App\Providers;

use App\Models\UserManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $permissions = [];

            if (Auth::check()) {
                $user = Auth::user();
                $userPermission = UserManagement::where('user_id', $user->id)->first();

                if ($userPermission) {
                    // Assuming your 'permissions' field is JSON or array
                    $permissions = $userPermission ? $userPermission->permissions : [];
                }
            }
            $view->with('global_permissions', $permissions);
        });
    }
}
