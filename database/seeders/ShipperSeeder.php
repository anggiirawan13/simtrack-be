<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ShipperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        // Generate 30 fake users
        foreach (range(5, 37) as $index) {
            DB::table('shippers')->insert([
                'user_id' => $index,  // Ganti dengan password yang diinginkan
                'device_mapping' => $faker->uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
