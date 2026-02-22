<?php

declare(strict_types=1);

namespace Infrastructure\Redis\Adapter;

use Infrastructure\Redis\Adapter\Contracts\UserCacheInterface;
use Infrastructure\Redis\Enums\UserRedisKeysEnum;
use Infrastructure\Redis\RecordObjects\UserRecord;
use Infrastructure\Redis\ScriptsHandler\CleanupUsersScript;
use Infrastructure\Redis\ScriptsHandler\CreateUserScript;
use Redis;

final class UserRedisClientAdapter implements UserCacheInterface
{
    /**
     * @param Redis $redis
     */
    public function __construct(
        private readonly Redis $redis
    ) {}

    /**
     * @param UserRecord $user
     * @return bool
     */
    public function save(UserRecord $user): bool
    {
        return new CreateUserScript(
            $this->redis,
        )->execute($user->nickname, $user->avatar, $user->createdAt);
    }

    /**
     * @param string $hashName
     * @return UserRecord|null
     */
    public function findByHashName(string $hashName): ?UserRecord
    {
        $data = $this->redis->hGetAll($hashName);

        if ($data === []) {
            return null;
        }

        return new UserRecord(
            nickname: $data['nickname'],
            avatar: $data['avatar'],
            createdAt: (int) $data['created_at'],
        );
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $hashNames = $this->redis->zRange(UserRedisKeysEnum::indexName(), 0, -1);

        return array_map(fn ($hashName) => $this->findByHashName($hashName), $hashNames);

    }

    /**
     * @param int $cutoffTimestamp
     * @return bool
     */
    public function deleteByTimestamp(int $cutoffTimestamp): bool
    {
        return new CleanupUsersScript($this->redis)->execute($cutoffTimestamp);
    }
}
