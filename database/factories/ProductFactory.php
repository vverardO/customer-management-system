<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'value' => fake()->randomFloat(2, 0, 1000),
            'company_id' => Company::factory(),
        ];
    }
}
