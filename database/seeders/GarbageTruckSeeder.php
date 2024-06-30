<?php

namespace Database\Seeders;

use App\Models\GarbageTruck;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GarbageTruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GarbageTruck::create( [
            'license_plate'=>'BL 123 ABC',
            'driver_name'=>'John Doe',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    }
}