<?php

namespace Database\Seeders;

use App\Models\Landfill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandfillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Landfill::create( [
            'name'=>'TPA-1',
            'address'=>'TPAS Alue Lim, Lhoksemawe',
            'latitude'=>5.129523361146446,
            'longitude'=>97.1197617856933,
        ] );
    }
}