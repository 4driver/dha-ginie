<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Package;
use Faker\Provider\Lorem;

class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company,
            'services' => 'Service A, Service B, Service C',
            'price' => $this->faker->numberBetween(5000,10000),
            'offer_price' => $this->faker->numberBetween(1,4999),
            'visits' => $this->faker->numberBetween(1,10),
            'duration' => '1 Month',
            'description' => Lorem::paragraphs(1,true),
            'status' => TRUE,
        ];
    }
}
