<?php

namespace Database\Seeders;

use App\Models\AccessRole;
use App\Models\Company;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::factory()
            ->hasServices(30)
            ->hasProducts(30)
            ->hasCustomers(10)
            ->create();

        $company
            ->customers()
            ->inRandomOrder()
            ->take(5)
            ->each(function ($customer) use ($company) {
                Order::factory()
                    ->count(random_int(1, 3))
                    ->for($company)
                    ->for($customer)
                    ->create()
                    ->each(function ($order) {
                        $totalValue = 0;
                        $quantity = random_int(1, 5);
                        Service::inRandomOrder()->take($quantity)->get()->each(function ($service) use ($order, &$totalValue) {
                            $totalValue += $service->value;
                            $order->services()->attach($service, ['value' => $service->value]);
                        });

                        $order->update(['total_value' => $totalValue]);
                    });
            });

        User::factory([
            'access_role_id' => AccessRole::inRandomOrder()->first()->id,
        ])->count(5)
            ->for($company)
            ->create();
    }
}
