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
            'name'=>'TP-01',
            'address'=>'Pasar Ikan Kota',
            'latitude'=>5.1743300465384925,
            'longitude'=>97.15182460408074,
            'volume'=>3,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-02',
            'address'=>'Jembatan Cunda',
            'latitude'=>5.177609224689046,
            'longitude'=>97.1309664383782,
            'volume'=>3,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-03',
            'address'=>'Lapas',
            'latitude'=>5.179721194805425,
            'longitude'=>97.14919229604787,
            'volume'=>3,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-04',
            'address'=>'Pasar Impress',
            'latitude'=>5.183698024888871,
            'longitude'=>97.14214909604787,
            'volume'=>3,
        ] );
                    
        DumpingPlace::create( [
            'name'=>'TP-05',
            'address'=>'Cunda',
            'latitude'=>5.17502125785481,
            'longitude'=>97.13052941867875,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-06',
            'address'=>'Kompi Brimob',
            'latitude'=>5.1360689732979345, 
            'longitude'=>97.10741558935334,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-07',
            'address'=>'Pesantren Lhok Mon Puteh',
            'latitude'=>5.161217716628103, 
            'longitude'=>97.12951739729212,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-08',
            'address'=>'Politeknik',
            'latitude'=>5.12061430884697, 
            'longitude'=>97.15836629604782,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-09',
            'address'=>'Rumah Sakit Umum',
            'latitude'=>5.122130885020789,  
            'longitude'=>97.15636769947595,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-10',
            'address'=>'Dayah Paloh',
            'latitude'=>5.210156231461788,   
            'longitude'=>97.08471478805713,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-11',
            'address'=>'Punteut',
            'latitude'=>5.116045358867643,   
            'longitude'=>97.16824208769637,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-12',
            'address'=>'Blang Rayeuk',
            'latitude'=>5.1945017596565615,  
            'longitude'=>97.13469391931989,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-13',
            'address'=>'Dayah Abu Bakar',
            'latitude'=>5.115357174117849,
            'longitude'=>97.17215828023463,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-14',
            'address'=>'Kesrem',
            'latitude'=>5.182429719088079, 
            'longitude'=>97.15021954000673,
            'volume'=>3,
        ] );

        DumpingPlace::create( [
            'name'=>'TP-15',
            'address'=>'Lapangan BI',
            'latitude'=>5.206248551411561, 
            'longitude'=>97.07304011174924,
            'volume'=>3,
        ] );

    }
}
