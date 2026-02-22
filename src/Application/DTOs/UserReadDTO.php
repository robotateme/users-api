<?php

namespace Application\DTOs;

final class UserReadDTO
{
    public function __construct(
        public ?string $nickname,
        public ?string $avatar,
        public ?string $created_at,
    ) {}

}
