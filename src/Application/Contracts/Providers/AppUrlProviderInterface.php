<?php

namespace Application\Contracts\Providers;

interface AppUrlProviderInterface
{
    public function getAppUrl(): string;
}
