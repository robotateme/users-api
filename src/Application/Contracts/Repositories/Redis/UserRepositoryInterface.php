<?php

declare(strict_types=1);

namespace Application\Contracts\Repositories\Redis;

use Domains\User\UserEntity;

interface UserRepositoryInterface
{
    /**
     * @return iterable
     */
    public function list(): iterable;

    /**
     * @param UserEntity $user
     * @return bool
     */
    public function register(UserEntity $user): bool;

    /**
     * @param int $cutoffTimestamp
     * @return bool
     */
    public function cleanUp(int $cutoffTimestamp): bool;
}
