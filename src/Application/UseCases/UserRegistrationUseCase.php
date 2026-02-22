<?php

namespace Application\UseCases;

use Application\DTOs\UserRegistrationDTO;
use Application\UseCases\Exceptions\NicknameAlreadyExists;
use Infrastructure\Redis\RecordObjects\UserRecord;
use Infrastructure\Redis\Repositories\UserRepository;

class UserRegistrationUseCase
{
    public function __construct(private readonly UserRepository $userRedisRepository) {}

    /**
     * @throws NicknameAlreadyExists
     */
    public function execute(UserRegistrationDTO $userRegistrationDTO): bool
    {
        $record = new UserRecord(
            nickname: $userRegistrationDTO->nickname,
            avatar: $userRegistrationDTO->avatarUri,
            createdAt: time()
        );
        if (! $this->userRedisRepository->save($record)) {
            throw new NicknameAlreadyExists;
        }

        return true;
    }
}
