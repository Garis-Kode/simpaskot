<?php

use App\Http\Controllers\AnalystController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DumpingPlaceController;
use App\Http\Controllers\GarbageTruckController;
use App\Http\Controllers\LandfillController;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\RouteController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('/auth')->middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
});
Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); 


Route::prefix('/pool')->group(function () {
    Route::get('/', [PoolController::class, 'index'])->name('pool');
    Route::post('/', [PoolController::class, 'store'])->name('pool.store');
    Route::post('/{id}', [PoolController::class, 'update'])->name('pool.update');
    Route::get('/{id}', [PoolController::class, 'destroy'])->name('pool.destroy');
})->middleware('auth');

Route::prefix('/landfill')->group(function () {
    Route::get('/', [LandfillController::class, 'index'])->name('landfill');
    Route::post('/', [LandfillController::class, 'store'])->name('landfill.store');
    Route::post('/{id}', [LandfillController::class, 'update'])->name('landfill.update');
    Route::get('/{id}', [LandfillController::class, 'destroy'])->name('landfill.destroy');
})->middleware('auth');

Route::prefix('/dumping-place')->group(function () {
    Route::get('/', [DumpingPlaceController::class, 'index'])->name('dumping-place');
    Route::post('/', [DumpingPlaceController::class, 'store'])->name('dumping-place.store');
    Route::post('/{id}', [DumpingPlaceController::class, 'update'])->name('dumping-place.update');
    Route::get('/{id}', [DumpingPlaceController::class, 'destroy'])->name('dumping-place.destroy');
})->middleware('auth');

Route::prefix('/garbage-truck')->group(function () {
    Route::get('/', [GarbageTruckController::class, 'index'])->name('garbage-truck');
    Route::post('/', [GarbageTruckController::class, 'store'])->name('garbage-truck.store');
    Route::post('/{id}', [GarbageTruckController::class, 'update'])->name('garbage-truck.update');
    Route::get('/{id}', [GarbageTruckController::class, 'destroy'])->name('garbage-truck.destroy');
})->middleware('auth');

Route::prefix('/route')->group(function () {
    Route::get('/', [RouteController::class, 'index'])->name('route');
    Route::post('/', [RouteController::class, 'store'])->name('route.store');
    Route::post('/{id}', [RouteController::class, 'update'])->name('route.update');
    Route::get('/{id}', [RouteController::class, 'destroy'])->name('route.destroy');
})->middleware('auth');

Route::prefix('/analyst')->group(function () {
    Route::get('/{id}', [AnalystController::class, 'index'])->name('analyst');
})->middleware('auth');

Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'user'])->name('user');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::post('/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');
})->middleware('auth');