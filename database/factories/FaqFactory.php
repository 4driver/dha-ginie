<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Faq;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Provider\Lorem;

class FaqFactory extends Factory
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
            'question' => Lorem::paragraphs(1,true),
            'answer' => Lorem::paragraphs(2,true),
        ];
    }
}
