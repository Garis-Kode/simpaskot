<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DumpingPlaceController;
use App\Http\Controllers\GarbageTruckController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('/auth')->middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
});
Route::get('auth/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('dashboard', function () {
    return view('dashboard', [
        'title' => 'Dashboard',
        'subTitle' => null,
        'page_id' => 7,
        ]);
})->name('dashboard'); 

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

Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'user'])->name('user');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::post('/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');
})->middleware('auth');