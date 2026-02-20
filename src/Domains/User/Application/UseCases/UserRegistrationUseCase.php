<?php

namespace Domains\User\Application\UseCases;

use Domains\User\Application\DTOs\UserRegistrationDTO;
use Domains\User\Application\UseCases\Exceptions\NicknameAlreadyExists;
use Domains\User\Infrastructure\Repositories\Redis\UserRedisWriteRepository;

class UserRegistrationUseCase
{
    public function __construct(private readonly UserRedisWriteRepository $userRedisRepository) {}

    /**
     * @param UserRegistrationDTO $userRegistrationDTO
     * @return bool
     * @throws NicknameAlreadyExists
     */
    public function execute(UserRegistrationDTO $userRegistrationDTO): bool
    {
        if (! $this->userRedisRepository->save($userRegistrationDTO)) {
            throw new NicknameAlreadyExists;
        }

        return true;
    }
}
