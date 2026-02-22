<?php

namespace Application\UseCases;

use Application\Commands\UserCleanupCommand;
use Infrastructure\Redis\Repositories\UserRepository;

class UsersCleanupUseCase
{
    public function __construct(private readonly UserRepository $userRepository) {}

    /**
     * @param UserCleanupCommand $command
     * @return void
     */
    public function execute(UserCleanupCommand $command): void
    {
        $this->userRepository->cleanUp($command->cutoffTimestamp);
    }
}
