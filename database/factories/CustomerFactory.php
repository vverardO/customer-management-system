<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        [
            $one,
            $two,
            $three,
            $four,
        ] = [
            substr(str_shuffle('0123456789'), 0, 3),
            substr(str_shuffle('0123456789'), 0, 3),
            substr(str_shuffle('0123456789'), 0, 3),
            substr(str_shuffle('0123456789'), 0, 2),
        ];

        $document = str_shuffle('0123456789');

        return [
            'name' => fake()->unique()->name(),
            'general_record' => $document,
            'registration_physical_person' => "$one.$two.$three-$four",
            'company_id' => Company::inRandomOrder()->first()->id,
        ];
    }
}
