<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Complaint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Provider\Lorem;

class ComplaintFactory extends Factory
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
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'message' => Lorem::paragraphs(5,true),
        ];
    }
}
