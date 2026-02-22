<?php

namespace Infrastructure\Providers;

use DateTimeImmutable;
use Infrastructure\Providers\Contracts\TimeProviderInterface;

class Clock implements TimeProviderInterface
{
    public function now(): int
    {
        return new DateTimeImmutable()->getTimestamp();
    }

    public function dateTime(): DateTimeImmutable
    {
        return new DateTimeImmutable;
    }
}
