<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AccessRoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
        ];
    }
}
