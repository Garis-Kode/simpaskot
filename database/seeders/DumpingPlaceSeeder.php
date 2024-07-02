<?php

namespace Database\Seeders;

use App\Models\DumpingPlace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DumpingPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DumpingPlace::create( [
            'name'=>'TP-001',
            'address'=>'Pasar Pusong Lama',
            'latitude'=>5.1743300465384925,
            'longitude'=>97.15182460408074,
            'volume'=>3.5,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-002',
            'address'=>'Pasar Impres',
            'latitude'=>5.183720162178924,
            'longitude'=>97.14214836388635,
            'volume'=>2.8,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-003',
            'address'=>'Samping Terminal Bus',
            'latitude'=>5.178554795779263,
            'longitude'=>97.13316891317545,
            'volume'=>4.2,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-004',
            'address'=>'Pasar Ikan Cunda',
            'latitude'=>5.175026950896422,
            'longitude'=>97.13053442811979,
            'volume'=>3,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-005',
            'address'=>'Politenik Negri Lhokseumawe',
            'latitude'=>5.120683767947704,
            'longitude'=>97.15835556651821,
            'volume'=>2.5,
        ] );
    }
}
