<?php

namespace Domains\User\Application\DTOs;

class UserDTO
{
    public function __construct(
        public string $nickname,
        public string $avatar,
        public int $createdAt,
    ) {}

}
