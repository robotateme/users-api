<?php

declare(strict_types=1);

namespace Infrastructure\Redis\ScriptsHandler;

use Infrastructure\Redis\Enums\UserRedisKeysEnum;
use Infrastructure\Redis\Enums\UserRedisPropertiesEnum;
use Redis;

final class CreateUserScript
{
    private string $sha;

    public function __construct(private readonly Redis $redis)
    {
        $script = file_get_contents(__DIR__.'/Scripts/CreateUser.lua');
        $this->sha = $this->redis->script('load', $script);
    }

    public function execute(string $nickname, string $avatar, int $time): bool
    {
        return $this->redis->evalSha(
            $this->sha, [
                UserRedisPropertiesEnum::NICKNAME->value,
                UserRedisPropertiesEnum::AVATAR->value,
                UserRedisPropertiesEnum::CREATED_AT->value,
                UserRedisKeysEnum::hashName($nickname),
                UserRedisKeysEnum::INDEX->value,
                $nickname,
                $avatar,
                $time,
            ], 3
        ) === 1;
    }
}
