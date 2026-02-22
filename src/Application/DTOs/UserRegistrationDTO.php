<?php

namespace Application\DTOs;

final class UserRegistrationDTO
{
    public function __construct(
        public string $nickname,
        public string $avatarUri,
    ) {}
}
