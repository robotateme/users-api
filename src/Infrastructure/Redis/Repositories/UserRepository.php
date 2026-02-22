<?php

declare(strict_types=1);

namespace Infrastructure\Redis\Repositories;

use ArrayIterator;
use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Infrastructure\Redis\Adapter\UserRedisClientAdapter;
use Infrastructure\Redis\RecordObjects\UserRecord;
use Infrastructure\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private UserRedisClientAdapter $userRedis;

    public function __construct(RedisFactory $redisFactory)
    {
        $redisClient = $redisFactory->connection()->client();
        $this->userRedis = new UserRedisClientAdapter($redisClient);
    }

    public function list(): iterable
    {
        return new ArrayIterator($this->userRedis->findAll());
    }

    public function save(UserRecord $record): bool
    {
        return $this->userRedis->save($record);
    }

    public function cleanUp(int $cutoffTimestamp): bool
    {
        return $this->userRedis->deleteByTimestamp($cutoffTimestamp);
    }
}
