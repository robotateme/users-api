<?php

declare(strict_types=1);

namespace Infrastructure\Repositories\Contracts;

use Domains\User\UserEntity;

interface UserRepositoryInterface
{
    public function list(): iterable;

    /**
     * @param UserEntity $user
     * @return bool
     */
    public function register(UserEntity $user): bool;

    public function cleanUp(int $cutoffTimestamp): bool;
}
