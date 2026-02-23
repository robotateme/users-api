<?php

namespace App\Providers;

use Application\Contracts\Providers\AppUrlProviderInterface;
use Application\Contracts\Providers\RateLimiterInterface;
use Application\Contracts\Providers\TimeProviderInterface;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Providers\Clock;
use Infrastructure\Providers\LaravelAppUrlProvider;
use Infrastructure\Redis\Adapter\RedisRateLimiter;

class InfrastructureProviders extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AppUrlProviderInterface::class, LaravelAppUrlProvider::class);
        $this->app->bind(TimeProviderInterface::class, Clock::class);
        $this->app->bind(RateLimiterInterface::class, RedisRateLimiter::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
