<?php

namespace Infrastructure\Providers\Contracts;

interface AppUrlProviderInterface
{
    public function getAppUrl(): string;
}
