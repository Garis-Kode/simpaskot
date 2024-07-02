<?php

namespace App\Http\Controllers;

use App\Models\GarbageTruck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GarbageTruckController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Garbage Truck',
            'subTitle' => null,
            'data' => GarbageTruck::all()
        ];
        return view('pages.garbage_truck', $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'plate' => 'required',
            'driver' => 'required',
            'price' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('garbage-truck')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = New GarbageTruck();
        $data->license_plate = $request->input('plate');
        $data->driver_name = $request->input('driver');
        $data->fuel_price = $request->input('price');
        $data->volume = $request->input('volume');
        $data->type = $request->input('type');
        $data->save();
        return redirect()->route('garbage-truck')->with('success', 'New data has been successfully added');
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'plate' => 'required',
            'driver' => 'required',
            'price' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('garbage-truck')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = GarbageTruck::findOrFail($id);
        $data->license_plate = $request->input('plate');
        $data->driver_name = $request->input('driver');
        $data->fuel_price = $request->input('price');
        $data->volume = $request->input('volume');
        $data->type = $request->input('type');
        $data->save();
        return redirect()->route('garbage-truck')->with('success', 'Data has been successfully updated');
    }

    public function destroy($id){
        $boats = GarbageTruck::findOrFail($id);
        $boats->delete();
        return redirect()->route('garbage-truck')->with('success', 'Data has been successfully deleted');
    }
}
