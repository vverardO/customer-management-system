<?php

namespace Database\Factories;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        $createdAndUpdatedAt = Carbon::today()->subDays(rand(0, 40));

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
            'company_id' => Company::factory(),
            'created_at' => $createdAndUpdatedAt,
            'updated_at' => $createdAndUpdatedAt,
        ];
    }
}
