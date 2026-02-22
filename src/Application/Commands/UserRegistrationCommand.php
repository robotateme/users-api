<?php

namespace Application\Commands;

final class UserRegistrationCommand
{
    public function __construct(
        public string $nickname,
        public string $avatarUri,
    ) {}
}
