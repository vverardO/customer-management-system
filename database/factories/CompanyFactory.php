<?php

namespace Database\Factories;

use App\Models\AccessRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        $identificator = str_shuffle(
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
        );

        return [
            'name' => fake()->name(),
            'identificator' => $identificator,
        ];
    }
}
