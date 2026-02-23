<?php

namespace App\Providers;

use Application\Contracts\Repositories\Redis\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Redis\Repositories\UserRepository;

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
