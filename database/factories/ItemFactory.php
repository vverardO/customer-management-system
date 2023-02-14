<?php

namespace Database\Factories;

use App\Enums\ItemType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->boolean() ? ItemType::Product : ItemType::Service;

        return [
            'name' => fake()->sentence(2),
            'value' => fake()->randomFloat(2, 0, 1000),
            'quantity' => $type == ItemType::Product ? 0 : null,
            'warning' => $type == ItemType::Product ? 10 : null,
            'type' => $type,
            'company_id' => Company::factory(),
        ];
    }
}
