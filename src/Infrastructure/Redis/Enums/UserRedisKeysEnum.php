<?php
declare(strict_types=1);

namespace Infrastructure\Redis\Enums;

enum UserRedisKeysEnum: string
{
    case NAMESPACE = 'users:%s';
    case INDEX = 'users:index';

    /**
     * @param string $nickname
     * @return string
     */
    public static function hashName(string $nickname): string
    {
        return sprintf(self::NAMESPACE->value, $nickname);
    }

    /**
     * @return string
     */
    public static function indexName(): string
    {
        return self::INDEX->value;
    }
}
