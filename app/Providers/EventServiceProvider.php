<?php

namespace App\Providers;

use App\Models\Entry;
use App\Models\Output;
use App\Observers\EntryObserver;
use App\Observers\OutputObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    protected $observers = [
        Output::class => [OutputObserver::class],
        Entry::class => [EntryObserver::class],
    ];

    public function boot(): void
    {
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
