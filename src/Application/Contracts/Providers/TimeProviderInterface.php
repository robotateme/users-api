<?php

namespace Application\Contracts\Providers;

interface TimeProviderInterface
{
    public function now(): int;
}
