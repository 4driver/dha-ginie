<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use Faker\Provider\Lorem;

class PaymentFactory extends Factory
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
            'title' => $this->faker->name,
            'type' => 'Debit/Credit Card',
            'amount' => $this->faker->numberBetween(0,10000),
            'payment_status' => 'Unpaid',
            'date' => $this->faker->dateTime($date),
        ];
    }
}
