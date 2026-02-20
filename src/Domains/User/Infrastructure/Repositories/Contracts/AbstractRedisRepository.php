<?php

namespace Domains\User\Infrastructure\Repositories\Contracts;

use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Illuminate\Redis\Connections\Connection;

class AbstractRedisRepository
{
    protected Connection $connection;

    /**
     * @param RedisFactory $redis
     */
    public function __construct(RedisFactory $redis)
    {
        $this->connection = $redis->connection();
    }
}
