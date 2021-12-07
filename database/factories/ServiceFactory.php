<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\Lorem;
use App\Models\Category;
use App\Models\Service;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = Category::inRandomOrder()->first();

        return [
            'name' => $this->faker->name,
            'category_id' => $category->id,
            'description' => Lorem::paragraphs(1,true),
            'status' => TRUE,
        ];
    }
}
