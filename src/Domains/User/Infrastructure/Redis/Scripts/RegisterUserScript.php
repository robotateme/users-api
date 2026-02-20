<?php

namespace Domains\User\Infrastructure\Redis\Scripts;

use Domains\User\Infrastructure\Enums\UserRedisKeysEnum;
use Illuminate\Redis\Connections\Connection;

final class RegisterUserScript
{
    private string $sha;

    public function __construct(private readonly Connection $redis)
    {
        $script = file_get_contents(__DIR__.'/RegisterUser.lua');
        $this->sha = $this->redis->client()->script('load', $script);
    }

    public function execute(string $nickname, string $avatar): bool
    {
        return $this->redis->client()->evalSha(
            $this->sha, [
                UserRedisKeysEnum::namespace($nickname),
                UserRedisKeysEnum::INDEX->value,
                $nickname,
                $avatar,
                time(),
            ],
        ) === 1;
    }
}
