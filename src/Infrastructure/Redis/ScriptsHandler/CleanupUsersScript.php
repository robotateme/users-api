<?php

declare(strict_types=1);

namespace Infrastructure\Redis\ScriptsHandler;

use Infrastructure\Redis\Enums\UserRedisKeysEnum;
use Redis;

final class CleanupUsersScript
{
    private string $sha;

    public function __construct(private readonly Redis $redis)
    {
        $script = file_get_contents(__DIR__.'/Scripts/CleanupUsers.lua');
        $this->sha = $this->redis->script('load', $script);
    }

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
