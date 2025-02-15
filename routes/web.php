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
Route::get('substation',[SubstationController::class,'index'])->name('substation');
Route::get('asset',[AssetController::class,'index'])->name('asset');
Route::get('sensor',[SensorController::class,'index'])->name('sensor');
Route::get('report',[ReportController::class,'index'])->name('report');
Route::get('user_management',[UserManagementController::class,'index'])->name('user_management');

require __DIR__.'/auth.php';
