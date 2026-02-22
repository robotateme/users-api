<?php

namespace Application\Commands;

final readonly class UserCleanupCommand
{
    public function __construct(public int $cutoffTimestamp) {}
}
