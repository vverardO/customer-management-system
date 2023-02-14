<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutputFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(2),
            'item_id' => Item::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
