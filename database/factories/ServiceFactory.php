<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;
use Faker\Provider\Lorem;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'category_id' => $this->faker->numberBetween(1,10),
            'description' => Lorem::paragraphs(1,true),
            'status' => TRUE,
        ];
    }
}
