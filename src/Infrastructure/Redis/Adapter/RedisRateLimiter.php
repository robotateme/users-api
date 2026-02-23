<?php

namespace Infrastructure\Redis\Adapter;

use Application\Contracts\Providers\RateLimiterInterface;
use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Infrastructure\Redis\ScriptsHandler\RateLimiter;

class RedisRateLimiter implements RateLimiterInterface
{
    private RateLimiter $rateLimiter;

    /**
     * @param RedisFactory $redisFactory
     */
    public function __construct(RedisFactory $redisFactory)
    {
        $this->rateLimiter = new RateLimiter($redisFactory->connection()->client());
    }

    /**
     * @param string $key
     * @param int $windowSeconds
     * @param int $limit
     * @return bool
     */
    public function allow(string $key, int $windowSeconds, int $limit): bool
    {
        return $this->rateLimiter->execute($key, time(), $windowSeconds, $limit);
    }
}
