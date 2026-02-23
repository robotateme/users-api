<?php

declare(strict_types=1);

namespace Infrastructure\Redis\Repositories;

use Application\Contracts\Repositories\Redis\UserRepositoryInterface;
use ArrayIterator;
use Domains\User\UserEntity;
use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Infrastructure\Redis\Adapter\UserRedisClientAdapter;
use Infrastructure\Redis\RecordObjects\UserRecord;

class UserRepository implements UserRepositoryInterface
{
    private UserRedisClientAdapter $userRedis;

    /**
     * @param RedisFactory $redisFactory
     */
    public function __construct(RedisFactory $redisFactory)
    {
        $redisClient = $redisFactory->connection()->client();
        $this->userRedis = new UserRedisClientAdapter($redisClient);
    }

    /**
     * @return iterable
     */
    public function list(): iterable
    {
        return new ArrayIterator($this->userRedis->findAll());
    }

    /**
     * @param UserEntity $user
     * @return bool
     */
    public function register(UserEntity $user): bool
    {
        $userRecord = new UserRecord(
            nickname: $user->getNickname()->getValue(),
            avatar: $user->getAvatarUri()->getValue(),
            createdAt: $user->getCreatedAt()->getValue()->getTimestamp(),
        );

        return $this->userRedis->save($userRecord);
    }

    /**
     * @param int $cutoffTimestamp
     * @return bool
     */
    public function cleanUp(int $cutoffTimestamp): bool
    {
        return $this->userRedis->deleteByTimestamp($cutoffTimestamp);
    }
}
