<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Entry;
use App\Models\Item;
use App\Models\Order;
use App\Models\Output;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::factory()
            ->hasServices(15)
            ->hasProducts(15)
            ->create();

        Customer::factory()
            ->count(10)
            ->for($company)
            ->create()
            ->each(function ($customer) {
                Address::factory()
                    ->count(random_int(1, 3))
                    ->for($customer)
                    ->create();
            });

        $company
            ->customers()
            ->inRandomOrder()
            ->take(5)
            ->each(function ($customer) use ($company) {
                Order::factory()
                    ->count(random_int(1, 3))
                    ->for($company)
                    ->for($customer)
                    ->for($customer->addresses->first())
                    ->create()
                    ->each(function ($order) {
                        $totalValue = 0;

                        $quantity = random_int(1, 5);
                        Item::isService()
                            ->inRandomOrder()
                            ->take($quantity)
                            ->get()
                            ->each(function ($service) use ($order, &$totalValue) {
                                $totalValue += $service->value;
                                $order->services()
                                    ->attach($service, ['value' => $service->value]);
                            });

                        $quantity = random_int(1, 5);
                        Item::isProduct()
                            ->hasStock()
                            ->inRandomOrder()
                            ->take($quantity)
                            ->get()
                            ->each(function ($service) use ($order, &$totalValue) {
                                $totalValue += $service->value;
                                $order->products()
                                    ->attach($service, ['value' => $service->value]);
                            });

                        $order->update(['total_value' => $totalValue]);
                    });
            });

        User::factory()
            ->count(5)
            ->for($company)
            ->create();

        $quantity = random_int(1, 15);
        $company
            ->products()
            ->inRandomOrder()
            ->take($quantity)
            ->get()
            ->each(function ($product) use ($company) {
                Output::factory()
                    ->count(5)
                    ->for($company)
                    ->for($product)
                    ->create();
            });

        $quantity = random_int(1, 15);
        $company
            ->products()
            ->inRandomOrder()
            ->take($quantity)
            ->get()
            ->each(function ($product) use ($company) {
                Entry::factory()
                    ->count(5)
                    ->for($company)
                    ->for($product)
                    ->create();
            });
    }
}
