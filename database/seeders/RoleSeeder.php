<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'role' => 'ADMIN',
        ]);

        DB::table('roles')->insert([
            'role' => 'COMMISSIONER',
        ]);

        DB::table('roles')->insert([
            'role' => 'DIRECTOR',
        ]);

        DB::table('roles')->insert([
            'role' => 'SHIPPER',
        ]);
    }
}
