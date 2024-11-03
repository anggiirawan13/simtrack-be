<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('admin1@1234'),
            'role' => 'Admin', // you can specify any role here
            'address_id' => 1, // sample address_id, adjust as necessary
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'fullname' => 'Director One',
            'username' => 'director1',
            'password' => Hash::make('director1@1234'),
            'role' => 'Director', // you can specify any role here
            'address_id' => 1, // sample address_id, adjust as necessary
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'fullname' => 'Shipper One',
            'username' => 'shipper1',
            'password' => Hash::make('shipper1@1234'),
            'role' => 'Shipper', // you can specify any role here
            'address_id' => 1, // sample address_id, adjust as necessary
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
