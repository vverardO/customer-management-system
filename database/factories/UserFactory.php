<?php

namespace Database\Factories;

use App\Models\AccessRole;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'access_role_id' => AccessRole::inRandomOrder()->first()->id,
            'company_id' => Company::factory(),
            'status' => true,
        ];
    }
}
