<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'postcode' => $this->faker->postcode(),
            'street' => $this->faker->streetAddress(),
            'number' => $this->faker->randomNumber(3),
            'complement' => $this->faker->sentence(10),
            'neighborhood' => implode(' ', $this->faker->words(2)),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'customer_id' => Customer::inRandomOrder()->first()->id,
        ];
    }
}
