<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data contoh ke tabel addresses
        DB::table('addresses')->insert([
            'whatsapp' => '62898678213',
            'street' => 'Tangerang',
            'sub_district' => 'Tangerang',
            'district' => 'Tangerang',
            'city' => 'Tangerang',
            'province' => 'Tangerang',
            'postal_code' => '123456'
        ]);
    }
}
