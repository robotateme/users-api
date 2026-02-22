<?php

namespace Infrastructure\Providers\Contracts;

interface TimeProviderInterface
{
    public function now(): int;
}
