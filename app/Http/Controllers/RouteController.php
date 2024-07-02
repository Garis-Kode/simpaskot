<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\Route;
use App\Models\Landfill;
use App\Models\Location;
use App\Models\DumpingPlace;
use App\Models\GarbageTruck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    public function index(Request $request){
        $data = [
            'title' => 'Route',
            'subTitle' => null,
            'data' => Route::all(),
            'dumpingPlace' => DumpingPlace::all(),
            'garbageTruck' => GarbageTruck::all(),
            'pool' => Pool::all(),
            'landfill' => Landfill::all(),
        ];
        return view('pages.route',  $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'truck' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('garbage-truck')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = New Route();
        $data->garbage_truck_id = $request->input('truck');
        $data->name = $request->input('name');
        $data->pool_id = $request->input('pool');
        $data->landfill_id = $request->input('landfill');
        $data->save();

        foreach ($request->location as  $result) {
            Location::updateOrInsert([
                'route_id' => $data->id,
                'dumping_place_id' => $result
            ]);
        }
        
        return redirect()->route('route')->with('success', 'New data has been successfully added');
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'truck' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('garbage-truck')->with('error', 'error validation')->withInput()->withErrors($validator);
        }

        $data = Route::findOrFail($id);
        $data->garbage_truck_id = $request->input('truck');
        $data->name = $request->input('name');
        $data->save();

        if(is_array($request->location)){
            Location::where('route_id', $data->id)->delete();
            foreach ($request->location as  $result) {
                Location::updateOrInsert([
                    'route_id' => $data->id,
                    'dumping_place_id' => $result
                ]);
            }
        }else{
            Location::where('route_id', $data->id)->delete();
        }
        
        return redirect()->route('route')->with('success', 'New data has been successfully added');
    }

    public function destroy($id){
        $data = Route::findOrFail($id);
        $data->delete();
        return redirect()->route('route')->with('success', 'Data has been successfully deleted');
    }
}
