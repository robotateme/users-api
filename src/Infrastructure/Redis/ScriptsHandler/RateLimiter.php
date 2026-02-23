<?php

namespace Infrastructure\Redis\ScriptsHandler;

use Infrastructure\Redis\ScriptsHandler\Contracts\AbstractScriptsHandler;

final class RateLimiter extends AbstractScriptsHandler
{
    /**
     * @param string $key
     * @param int $now
     * @param int $window
     * @param int $limit
     * @return bool
     */
    public function execute(string $key, int $now, int $window, int $limit): bool
    {
        return $this->redis->evalsha($this->sha, [
            $key,
            $now,
            $window,
            $limit,
            uuid_create(),
        ], 1);
    }
}
