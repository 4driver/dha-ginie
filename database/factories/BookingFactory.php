<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use Faker\Provider\Lorem;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = '1461067200';

        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'service' => $this->faker->company,
            'location' => $this->faker->address,
            'date' => $this->faker->dateTime($date),
            'address' => $this->faker->address,
            'message' => Lorem::paragraphs(1,true),
        ];
    }
}
