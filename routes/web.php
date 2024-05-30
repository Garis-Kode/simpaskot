<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('/auth')->middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
});

Route::get('dashboard', function () {
    return view('dashboard', [
        'title' => 'Dashboard',
        'subTitle' => null,
        'page_id' => 7,
        ]);
})->name('dashboard'); 
