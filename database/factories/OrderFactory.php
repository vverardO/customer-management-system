<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'number' => fake()->unique()->randomNumber(3),
            'description' => fake()->sentence(10),
            'total_value' => fake()->randomFloat(2, 0, 1000),
            'company_id' => Company::factory(),
            'customer_id' => Customer::factory(),
        ];
    }
}
