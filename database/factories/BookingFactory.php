<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\Lorem;
use App\Models\Booking;
use App\Models\Service;

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

        $service = Service::inRandomOrder()->first();

        return [
            'user_id' => NULL,
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'category_id' => $service->category_id,
            'service_id' => $service->id,
            'location' => 'DHA',
            'date' => $this->faker->dateTime($date),
            'address' => $this->faker->address,
            'message' => Lorem::paragraphs(1,true),
            'status' => 2,
        ];
    }
}
