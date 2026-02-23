<?php

namespace Infrastructure\Providers;

use Application\Contracts\Providers\AppUrlProviderInterface;

class LaravelAppUrlProvider implements AppUrlProviderInterface
{

    /**
     * @return string
     */
    public function getAppUrl(): string
    {
        return config('app.url');
    }
}
