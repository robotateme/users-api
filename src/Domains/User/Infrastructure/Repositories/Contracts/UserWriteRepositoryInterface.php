<?php

namespace Domains\User\Infrastructure\Repositories\Contracts;

use Domains\User\Application\DTOs\UserRegistrationDTO;

interface UserWriteRepositoryInterface
{
    /**
     * @param UserRegistrationDTO $dto
     * @return bool
     */
    public function save(UserRegistrationDTO $dto): bool;
}
