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
            'role' => 'Admin', // you can specify any role here
            'address_id' => 1, // sample address_id, adjust as necessary
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'fullname' => 'Director One',
            'username' => 'director1',
            'password' => Crypt::encrypt('director1@1234'),
            'device_mapping' => '1',
            'role' => 'Director', // you can specify any role here
            'address_id' => 1, // sample address_id, adjust as necessary
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'fullname' => 'Shipper One',
            'username' => 'shipper1',
            'password' => Crypt::encrypt('shipper1@1234'),
            'device_mapping' => '1',
            'role' => 'Shipper', // you can specify any role here
            'address_id' => 1, // sample address_id, adjust as necessary
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $faker = Faker::create();

        // Generate 30 fake users
        foreach (range(1, 30) as $index) {
            DB::table('users')->insert([
                'password' => Crypt::encrypt('password'),  // Ganti dengan password yang diinginkan
                'fullname' => $faker->name,
                'username' => $faker->unique()->userName,
                'device_mapping' => '1',
                'role' => 'Shipper',  // Ganti dengan role yang ada
                'address_id' => 1,  // Sesuaikan jika ada relasi dengan tabel addresses
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
