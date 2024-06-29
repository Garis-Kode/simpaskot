<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\DumpingPlace;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Dashboard',
            'subTitle' => null,
            'route' => Route::all(),
            'dumpingPlace' => DumpingPlace::all()
        ];
        return view('dashboard', $data);
    }
}
