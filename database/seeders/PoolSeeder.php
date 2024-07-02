<?php

namespace Database\Seeders;

use App\Models\Pool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pool::create( [
            'name'=>'POOL',
            'address'=>'Kantor DLH Kota Lhoksemawe',
            'latitude'=>5.184861368120089,
            'longitude'=>97.14215563412252,
        ] );
    }
}
