<?php

namespace Infrastructure\Providers;

use Application\Contracts\Providers\TimeProviderInterface;
use DateTimeImmutable;

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
