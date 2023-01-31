<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'value' => fake()->randomFloat(2, 0, 1000),
            'company_id' => Company::inRandomOrder()->first()->id,
        ];
    }
}
