<?php

namespace Application\DTOs;

final readonly class UserCleanupDTO
{
    public function __construct(public int $cutoffTimestamp) {}
}
