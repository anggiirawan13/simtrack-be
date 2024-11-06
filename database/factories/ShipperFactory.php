<?php

namespace Database\Factories;

use App\Models\Shipper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipperFactory extends Factory
{
    protected $model = Shipper::class;

    public function definition()
    {
        return [
            'user_id' => 1, // Mengasumsikan ada factory untuk User, agar Shipper terhubung ke User
            'device_mapping' => $this->faker->uuid(), // Menghasilkan UUID acak untuk device_mapping
        ];
    }
}
