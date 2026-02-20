<?php

namespace Domains\User\Infrastructure\Repositories\Redis;

use Domains\User\Infrastructure\Enums\UserRedisKeysEnum;
use Domains\User\Infrastructure\Repositories\Contracts\AbstractRedisRepository;
use Domains\User\Infrastructure\Repositories\Contracts\UserReadRepositoryInterface;

class UserRedisReadRepository extends AbstractRedisRepository implements UserReadRepositoryInterface
{
    public function list(): array
    {
        $indexes = $this->connection->client()->zRevRange(UserRedisKeysEnum::INDEX->value, 0, -1);

        return array_map(function (string $index) {
            return $this->connection->client()
                ->hgetall($index);
        }, $indexes);
    }
}
