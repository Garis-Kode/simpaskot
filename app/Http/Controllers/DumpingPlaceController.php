<?php

namespace App\Http\Controllers;

use App\Models\DumpingPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DumpingPlaceController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Dumping Place',
            'subTitle' => null,
            'data' => DumpingPlace::all()
        ];
        return view('pages.dumping_place', $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'volume' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('dumping-place')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = New DumpingPlace();
        $data->name = $request->input('name');
        $data->address = $request->input('address');
        $data->latitude = $request->input('lat');
        $data->longitude = $request->input('long');
        $data->volume = $request->input('volume');
        $data->save();
        return redirect()->route('dumping-place')->with('success', 'New data has been successfully added');
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'volume' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('dumping-place')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = DumpingPlace::findOrFail($id);
        $data->name = $request->input('name');
        $data->address = $request->input('address');
        $data->latitude = $request->input('lat');
        $data->longitude = $request->input('long');
        $data->volume = $request->input('volume');
        $data->save();
        return redirect()->route('dumping-place')->with('success', 'Data has been successfully updated');
    }

    public function destroy($id){
        $boats = DumpingPlace::findOrFail($id);
        $boats->delete();
        return redirect()->route('dumping-place')->with('success', 'Data has been successfully deleted');
    }
}
