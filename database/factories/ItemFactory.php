<?php

namespace Database\Factories;

use App\Enums\ItemType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'value' => fake()->randomFloat(2, 0, 1000),
            'type' => fake()->boolean() ? ItemType::Product : ItemType::Service,
            'company_id' => Company::factory(),
        ];
    }
}
