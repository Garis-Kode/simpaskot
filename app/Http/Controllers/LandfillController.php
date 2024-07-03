<?php

namespace App\Http\Controllers;

use App\Models\Landfill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandfillController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Landfill',
            'subTitle' => null,
            'data' => Landfill::all()
        ];
        return view('pages.landfill', $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('landfill')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = New Landfill();
        $data->name = $request->input('name');
        $data->address = $request->input('address');
        $data->latitude = $request->input('lat');
        $data->longitude = $request->input('long');
        $data->save();
        return redirect()->route('landfill')->with('success', 'New data has been successfully added');
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('landfill')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = Landfill::findOrFail($id);
        $data->name = $request->input('name');
        $data->address = $request->input('address');
        $data->latitude = $request->input('lat');
        $data->longitude = $request->input('long');
        $data->save();
        return redirect()->route('landfill')->with('success', 'Data has been successfully updated');
    }

    public function destroy($id){
        $boats = Landfill::findOrFail($id);
        $boats->delete();
        return redirect()->route('landfill')->with('success', 'Data has been successfully deleted');
    }
}
