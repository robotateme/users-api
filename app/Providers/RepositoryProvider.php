<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Redis\Repositories\UserRepository;
use Infrastructure\Redis\Repositories\UserWriteRepository;
use Infrastructure\Repositories\Contracts\UserRepositoryInterface;
use Infrastructure\Repositories\Contracts\UserWriteRepositoryInterface;

class RepositoryProvider extends ServiceProvider
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
