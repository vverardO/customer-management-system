<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Company::factory()
            ->hasUsers(5)
            ->hasServices(30)
            ->hasCustomers(10)
            ->hasOrders(15)
            ->create();
    }
}
