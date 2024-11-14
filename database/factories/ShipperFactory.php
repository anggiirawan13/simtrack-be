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
            'user_id' => 1,
            'device_mapping' => $this->faker->uuid(),
        ];
    }
}
