<?php

declare(strict_types=1);

namespace Infrastructure\Redis\ScriptsHandler;

use Infrastructure\Redis\Enums\UserRedisKeysEnum;
use Infrastructure\Redis\Enums\UserRedisPropertiesEnum;
use Infrastructure\Redis\ScriptsHandler\Contracts\AbstractScriptsHandler;

final class CreateUserScript extends AbstractScriptsHandler
{
    /**
     * @param string $nickname
     * @param string $avatar
     * @param int $time
     * @return bool
     */
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
