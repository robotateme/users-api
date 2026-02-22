<?php
declare(strict_types=1);

namespace Infrastructure\Redis\Enums;

enum UserRedisPropertiesEnum: string
{
    case NICKNAME = 'nickname';
    case ID = 'id';
    case AVATAR = 'avatar';
    case CREATED_AT = 'created_at';
}
