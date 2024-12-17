<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('delivery_status')->insert([
            'status' => 'DIPROSES',
        ]);

        DB::table('delivery_status')->insert([
            'status' => 'DIKIRIM',
        ]);

        DB::table('delivery_status')->insert([
            'status' => 'DITERIMA',
        ]);
    }
}
