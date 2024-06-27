<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DumpingPlaceSeeder;
use Database\Seeders\GarbageTruckSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DumpingPlaceSeeder::class,
            GarbageTruckSeeder::class,
        ]);
    }
}
