<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('delivery_statuses')->insert([
            'status' => 'DIPROSES',
        ]);

        DB::table('delivery_statuses')->insert([
            'status' => 'DIKIRIM',
        ]);

        DB::table('delivery_statuses')->insert([
            'status' => 'DITERIMA',
        ]);
    }
}
