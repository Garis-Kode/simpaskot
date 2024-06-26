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
            'type'=>'TPS',
            'address'=>'Pasar Pusong Lama',
            'latitude'=>5.1823,
            'longitude'=>97.1457,
            'volume'=>3.5,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-002',
            'type'=>'TPS',
            'address'=>'Pasar Impres',
            'latitude'=>5.1862,
            'longitude'=>97.1445,
            'volume'=>2.8,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-003',
            'type'=>'TPS',
            'address'=>'Samping Terminal Bus',
            'latitude'=>'5.1901',
            'longitude'=>'97.1433',
            'volume'=>4.2,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-004',
            'type'=>'TPS',
            'address'=>'Pasar Ikan Cunda',
            'latitude'=>5.1950,
            'longitude'=>97.1421,
            'volume'=>3,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-005',
            'type'=>'TPS',
            'address'=>'Politenik Negri Lhokseumawe',
            'latitude'=>5.1990,
            'longitude'=>97.1410,
            'volume'=>2.5,
        ] );
    }
}
