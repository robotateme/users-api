<?php

namespace App\Providers;

use Domains\User\Infrastructure\Repositories\Contracts\UserWriteRepositoryInterface;
use Domains\User\Infrastructure\Repositories\Redis\UserRedisReadRepository;
use Domains\User\Infrastructure\Repositories\Contracts\UserReadRepositoryInterface;
use Domains\User\Infrastructure\Repositories\Redis\UserRedisWriteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserReadRepositoryInterface::class, UserRedisReadRepository::class);
        $this->app->bind(UserWriteRepositoryInterface::class, UserRedisWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
