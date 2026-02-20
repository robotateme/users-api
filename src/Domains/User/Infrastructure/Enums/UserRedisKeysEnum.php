<?php

namespace Domains\User\Infrastructure\Enums;

enum UserRedisKeysEnum: string
{
    case NAMESPACE = 'users:%s';
    case INDEX = 'users:index';

    /**
     * @param string $nickname
     * @return string
     */
    public static function namespace(string $nickname): string
    {
        return sprintf(self::NAMESPACE->value, $nickname);
    }
}
