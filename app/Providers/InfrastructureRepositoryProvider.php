<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Redis\Repositories\UserRepository;
use Infrastructure\Repositories\Contracts\UserRepositoryInterface;

class InfrastructureRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
