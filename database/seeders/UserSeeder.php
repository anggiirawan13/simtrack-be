<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Crypt;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'fullname' => 'Administrator One',
            'username' => 'administrator1',
            'password' => Crypt::encrypt('admin1@1234'),
            'device_mapping' => '1',
            'role' => 'Admin',
            'address_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'fullname' => 'Director One',
            'username' => 'director1',
            'password' => Crypt::encrypt('director1@1234'),
            'device_mapping' => '1',
            'role' => 'Director',
            'address_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'fullname' => 'Shipper One',
            'username' => 'shipper1',
            'password' => Crypt::encrypt('shipper1@1234'),
            'device_mapping' => '1',
            'role' => 'Shipper',
            'address_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $faker = Faker::create();

       
        foreach (range(1, 30) as $index) {
            DB::table('users')->insert([
                'password' => Crypt::encrypt('password'), 
                'fullname' => $faker->name,
                'username' => $faker->unique()->userName,
                'device_mapping' => '1',
                'role' => 'Shipper', 
                'address_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
