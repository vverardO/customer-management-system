<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Company::factory(3)
            ->hasUsers(5)
            ->hasCustomers(30)
            ->create();
    }
}
