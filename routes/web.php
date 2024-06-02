<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DumpingPlaceController;

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

Route::get('/dumping-place', [DumpingPlaceController::class, 'index'])->name('dumping-place');
Route::post('/dumping-place', [DumpingPlaceController::class, 'store'])->name('dumping-place.store');
Route::post('/dumping-place/{id}', [DumpingPlaceController::class, 'update'])->name('dumping-place.update');
Route::get('/dumping-place/{id}', [DumpingPlaceController::class, 'destroy'])->name('dumping-place.destroy');

Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'user'])->name('user');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::post('/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');
});