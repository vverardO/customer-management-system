<?php

namespace Database\Seeders;

use App\Models\AccessRole;
use App\Models\Company;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::factory()
            ->hasServices(30)
            ->hasCustomers(10)
            ->create();

        Order::factory([
            'customer_id' => $company->customers()->inRandomOrder()->first()->id,
        ])->count(15)
            ->for($company)
            ->create();

        User::factory([
            'access_role_id' => AccessRole::inRandomOrder()->first()->id,
        ])->count(5)
            ->for($company)
            ->create();
    }
}
