<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard', [
        'title' => 'Dashboard',
        'subTitle' => null,
        'page_id' => 7,
        ]);
})->name('dashboard'); 
