<?php

namespace App\Providers;

use App\Services\AddressSearch\Contracts\AddressSearchInterface;
use App\Services\AddressSearch\ViaCEP\ViaCEP;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AddressSearchInterface::class,
            ViaCEP::class
        );
    }

    public function boot(): void
    {
    }
}
