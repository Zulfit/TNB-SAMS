<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserManagement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_routes_stay_public(): void
    {
        $this->get('/')->assertRedirect(route('login'));
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
        $this->get('/forgot-password')->assertOk();
    }

    public function test_guests_are_redirected_to_login_from_protected_routes(): void
    {
        $paths = [
            '/dashboard',
            '/analytics',
            '/sensor-table',
            '/substation',
            '/asset',
            '/sensor',
            '/bulk-create',
            '/dataset',
            '/error-log',
            '/error-log/assign/1',
            '/report',
            '/reports/download/1',
            '/user_management',
            '/chat/token',
            '/chat/token/header',
            '/chat/user/1',
            '/profile',
            '/about',
        ];

        foreach ($paths as $path) {
            $this->get($path)->assertRedirect(route('login'));
        }

        $this->post('/dashboard/stats-by-period')->assertRedirect(route('login'));
        $this->post('/dashboard/sensor-temperature')->assertRedirect(route('login'));
        $this->post('/bulk-store')->assertRedirect(route('login'));
        $this->post('/clear-toast')->assertRedirect(route('login'));
    }

    public function test_signed_in_users_without_a_screen_permission_are_forbidden(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/substation')->assertForbidden();
        $this->actingAs($user)->get('/sensor/create')->assertForbidden();
        $this->actingAs($user)->post('/substation', [])->assertForbidden();
        $this->actingAs($user)->get('/error-log/assign/1')->assertForbidden();
        $this->actingAs($user)->get('/reports/download/1')->assertForbidden();
        $this->actingAs($user)->post('/dashboard/sensor-temperature')->assertForbidden();
    }

    public function test_signed_in_users_with_the_screen_permission_can_open_the_module(): void
    {
        $user = User::factory()->create();

        UserManagement::create([
            'user_id' => $user->id,
            'permissions' => [
                'substation_access' => ['view'],
            ],
        ]);

        $this->actingAs($user)->get('/substation')->assertOk();
    }
}
