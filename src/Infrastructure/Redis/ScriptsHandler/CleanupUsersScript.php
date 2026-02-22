<?php

declare(strict_types=1);

namespace Infrastructure\Redis\ScriptsHandler;

use Infrastructure\Redis\Enums\UserRedisKeysEnum;
use Infrastructure\Redis\ScriptsHandler\Contracts\AbstractScriptsHandler;

final class CleanupUsersScript extends AbstractScriptsHandler
{
    /**
     * @return mixed
     */
    public function execute(int $cutoff): bool
    {
        return $this->redis->evalSha(
            $this->sha, [
                UserRedisKeysEnum::INDEX->value,
                $cutoff,
            ], 2
        ) === 1;
    }
}
