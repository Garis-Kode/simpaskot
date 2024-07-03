<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoolController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Pool',
            'subTitle' => null,
            'data' => Pool::all()
        ];
        return view('pages.pool', $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('pool')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = New Pool();
        $data->name = $request->input('name');
        $data->address = $request->input('address');
        $data->latitude = $request->input('lat');
        $data->longitude = $request->input('long');
        $data->save();
        return redirect()->route('pool')->with('success', 'New data has been successfully added');
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('pool')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = Pool::findOrFail($id);
        $data->name = $request->input('name');
        $data->address = $request->input('address');
        $data->latitude = $request->input('lat');
        $data->longitude = $request->input('long');
        $data->save();
        return redirect()->route('pool')->with('success', 'Data has been successfully updated');
    }

    public function destroy($id){
        $boats = Pool::findOrFail($id);
        $boats->delete();
        return redirect()->route('pool')->with('success', 'Data has been successfully deleted');
    }
}
