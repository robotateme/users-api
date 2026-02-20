<?php

namespace Domains\User\Infrastructure\Repositories\Redis;

use Domains\User\Application\DTOs\UserRegistrationDTO;
use Domains\User\Infrastructure\Redis\Scripts\RegisterUserScript;
use Domains\User\Infrastructure\Repositories\Contracts\AbstractRedisRepository;
use Domains\User\Infrastructure\Repositories\Contracts\UserWriteRepositoryInterface;

class UserRedisWriteRepository extends AbstractRedisRepository implements UserWriteRepositoryInterface
{
    /**
     * @param UserRegistrationDTO $dto
     * @return bool
     */
    public function save(UserRegistrationDTO $dto): bool
    {
        return new RegisterUserScript($this->connection)
            ->execute($dto->nickname, $dto->avatarUri);
    }
}
