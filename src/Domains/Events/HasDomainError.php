<?php

namespace Domains\Events;

use DateTime;
use Exception;

class HasDomainError implements Contracts\DomainEventInterface
{
    /**
     * @param  Exception  $exception  $
     */
    public function __construct(
        Exception $exception,
        string $classString,
        DateTime $dateTime,
    ) {}
}
