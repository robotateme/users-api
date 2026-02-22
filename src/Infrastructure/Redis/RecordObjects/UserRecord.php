<?php

namespace Infrastructure\Redis\RecordObjects;

final readonly class UserRecord
{
    public function __construct(
        public string $nickname,
        public string $avatar,
        public int $createdAt,
        public int $metric,
        public string $rank,
    ) {}
}
