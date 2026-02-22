<?php

namespace Application\UseCases;

use Application\DTOs\UserCleanupDTO;
use Infrastructure\Redis\Repositories\UserRepository;

class UsersCleanupUseCase
{
    public function __construct(private readonly UserRepository $userReadRepository) {}

    public function execute(UserCleanupDTO $dto): void
    {
        $this->userReadRepository->cleanUp($dto->cutoffTimestamp);
    }
}
