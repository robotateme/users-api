<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Providers\Clock;
use Infrastructure\Providers\Contracts\AppUrlProviderInterface;
use Infrastructure\Providers\Contracts\TimeProviderInterface;
use Infrastructure\Providers\LaravelAppUrlProvider;

class InfrastructureProviders extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AppUrlProviderInterface::class, LaravelAppUrlProvider::class);
        $this->app->bind(TimeProviderInterface::class, Clock::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
