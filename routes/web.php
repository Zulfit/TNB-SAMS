<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SubstationController;
use App\Http\Controllers\UserManagementController;
use GetStream\StreamChat\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

/*
| Dashboard pages and the JSON endpoints the dashboard scripts call.
| verified matches the previous dashboard resource middleware. The User
| model does not implement MustVerifyEmail, so this still admits any
| signed-in user until that contract is enabled.
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('/dashboard', DashboardController::class)->names(['index' => 'dashboard']);
    Route::post('/dashboard/stats-by-period', [DashboardController::class, 'getStatsByPeriod']);
    Route::get('/dashboard/panels/{substationId}', [DashboardController::class, 'getPanelsBySubstation']);
    Route::get('/dashboard/compartments/{panelId}', [DashboardController::class, 'getCompartmentsByPanel']);
    Route::post('/dashboard/sensor-temperature', [DashboardController::class, 'getSensorTemperature']);
    Route::post('/dashboard/sensor-partial-discharge', [DashboardController::class, 'getSensorPartialDischarge']);
    Route::post('/dashboard/get-panels', [DashboardController::class, 'getPanels'])->name('dashboard.get.panels');
    Route::post('/dashboard/get-compartments', [DashboardController::class, 'getCompartments'])->name('dashboard.get.compartments');
    Route::post('/dashboard/log-error', [DashboardController::class, 'logError']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('analytics', AnalyticsController::class)->names(['index' => 'analytics']);
    Route::get('/sensor-table', [AnalyticsController::class, 'sensorTable'])->name('sensorTable');
    Route::get('/sensor-chart', [AnalyticsController::class, 'sensorChartData'])->name('sensorChart');

    Route::resource('user_management', UserManagementController::class)
        ->names([
            'index' => 'user_management.index',
            'show' => 'user_management.show',
        ]);
    Route::resource('substation', SubstationController::class)->names(['index' => 'substation.index']);
    Route::resource('asset', AssetController::class)->names(['index' => 'asset.index']);
    Route::resource('sensor', SensorController::class)->names(['index' => 'sensor.index']);
    Route::get('/bulk-create', [SensorController::class, 'bulkCreate'])->name('sensor.bulk-create');
    Route::post('/bulk-store', [SensorController::class, 'bulkStore'])->name('sensor.bulk-store');

    Route::resource('report', ReportController::class)->names([
        'index' => 'report.index',
        'store' => 'report.store',
        'destroy' => 'report.destroy',
    ]);
    Route::get('/reports/download/{id}', [ReportController::class, 'download'])->name('report.download');

    Route::resource('error-log', ErrorLogController::class)->names(['index' => 'error-log.index', 'create' => 'error-log.create']);
    Route::get('error-log/assign/{id}', [ErrorLogController::class, 'assign'])->name('error-log.assign');
    Route::resource('dataset', DatasetController::class)->names(['index' => 'dataset.index']);

    Route::post('/clear-toast', function () {
        session()->forget('alert');

        return response()->json(['success' => true]);
    });

    Route::get('/chat/token', function () {
        $client = new Client(
            config('services.stream.key'),
            config('services.stream.secret')
        );

        $user = Auth::user();
        $userId = (string) $user->id; // important to keep as string for Stream

        // Create (or update) the current user in Stream
        $client->upsertUsers([
            [
                'id' => $userId,
                'name' => $user->name,
            ],
        ]);

        // Optional: if you're chatting with another user, create them too
        if (request()->has('target_user_id')) {
            $targetUserId = (string) request()->input('target_user_id');
            $targetUserName = \App\Models\User::find($targetUserId)?->name ?? 'Unknown';

            $client->upsertUsers([
                [
                    'id' => $targetUserId,
                    'name' => $targetUserName,
                ],
            ]);
        }

        $token = $client->createToken($userId);

        return Response::json([
            'user_id' => $userId,
            'user_name' => $user->name,
            'token' => $token,
            'api_key' => config('services.stream.key'),
        ]);
    });

    Route::get('/chat/user/{userId}', [ChatController::class, 'chatWithUser'])->name('chat.with.user');

    Route::get('/chat/token/header', function () {
        if (! Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $client = new Client(
            config('services.stream.key'),
            config('services.stream.secret')
        );
        $token = $client->createToken((string) $user->id);

        return response()->json([
            'api_key' => config('services.stream.key'),
            'token' => $token,
            'user_id' => (string) $user->id,
            'user_name' => $user->name,
        ]);
    });

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});

require __DIR__.'/auth.php';
