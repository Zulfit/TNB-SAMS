<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SubstationController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::resource('/analytics',AnalyticsController::class);
Route::get('analytics',[AnalyticsController::class,'index'])->name('analytics');
Route::get('dataset',[DatasetController::class,'index'])->name('dataset');

Route::get('report',[ReportController::class,'index'])->name('report');
Route::resource('user_management',UserManagementController::class)
->names([
    'index' => 'user_management.index',
    'show' => 'user_management.show'
]);
Route::resource('substation',SubstationController::class)->names(['index' => 'substation.index']);
Route::resource('asset',AssetController::class)->names(['index' => 'asset.index']);
Route::resource('sensor',SensorController::class)->names(['index' => 'sensor.index']);

require __DIR__.'/auth.php';
