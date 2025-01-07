<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'role_id' => 1,
            'address_id' => 1,
            'created_at' => now(),
            'created_by' => 1,
            'updated_at' => now(),
            'updated_by' => 1
        ]);

        DB::table('users')->insert([
            'fullname' => 'Commissioner One',
            'username' => 'commissioner1',
            'password' => Crypt::encrypt('commissioner1@1234'),
            'role_id' => 2,
            'address_id' => 1,
            'created_at' => now(),
            'created_by' => 1,
            'updated_at' => now(),
            'updated_by' => 1
        ]);

        DB::table('users')->insert([
            'fullname' => 'Director One',
            'username' => 'director1',
            'password' => Crypt::encrypt('director1@1234'),
            'role_id' => 3,
            'address_id' => 1,
            'created_at' => now(),
            'created_by' => 1,
            'updated_at' => now(),
            'updated_by' => 1
        ]);

        DB::table('users')->insert([
            'fullname' => 'Shipper One',
            'username' => 'shipper1',
            'password' => Crypt::encrypt('shipper1@1234'),
            'role_id' => 4,
            'address_id' => 1,
            'created_at' => now(),
            'created_by' => 1,
            'updated_at' => now(),
            'updated_by' => 1
        ]);
    }
}
