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
    
        GarbageTruck::create( [
            'license_plate'=>'BL 234 BCD',
            'driver_name'=>'Jane Smith',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 345 CDE',
            'driver_name'=>'Alice Johnson',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 456 DEF',
            'driver_name'=>'Bob Brown',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 567 EFG',
            'driver_name'=>'Charlie Davis',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 678 FGH',
            'driver_name'=>'David Evans',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 789 GHI',
            'driver_name'=>'Ella Foster',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 890 HIJ',
            'driver_name'=>'Frank Green',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 098 IJK',
            'driver_name'=>'Grace Hill',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 987 JKL',
            'driver_name'=>'Henry Ingram',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 876 KLM',
            'driver_name'=>'Ivy Jones',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 765 LMN',
            'driver_name'=>'Jack King',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 654 MNO',
            'driver_name'=>'Kara Lewis',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 543 NOP',
            'driver_name'=>'Liam Miller',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 432 OPQ',
            'driver_name'=>'Mia Nelson',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 321 PQR',
            'driver_name'=>'Noah Owens',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    
        GarbageTruck::create( [
            'license_plate'=>'BL 210 QRS',
            'driver_name'=>'Olivia Parker',
            'fuel_price'=> 1430,
            'type'=>'Dump Truck (Besar)',
        ] );
    }
    
}
