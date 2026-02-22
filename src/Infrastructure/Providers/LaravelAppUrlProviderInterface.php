<?php

namespace Infrastructure\Providers;

use Infrastructure\Providers\Contracts\AppUrlProviderInterface;

class LaravelAppUrlProviderInterface implements AppUrlProviderInterface
{

    /**
     * @return string
     */
    public function getAppUrl(): string
    {
        return config('app.url');
    }
}
