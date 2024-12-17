<?php

namespace Database\Seeders;

use App\Models\Shipper;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            StatusSeeder::class,
            AddressSeeder::class,
            UserSeeder::class,
            ShipperSeeder::class,
        ]);
    }
}
