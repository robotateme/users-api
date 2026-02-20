<?php

namespace Domains\User\Infrastructure\Enums;

enum UserRedisPropertiesEnum: string
{
    case NICKNAME = 'nickname';
    case ID = 'id';
    case AVATAR = 'avatar';
    case CREATED_AT = 'created_at';
}
