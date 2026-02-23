<?php

namespace Infrastructure\Redis\ScriptsHandler\Enums;

use Infrastructure\Redis\ScriptsHandler\CleanupUsersScript;
use Infrastructure\Redis\ScriptsHandler\CreateUserScript;
use Infrastructure\Redis\ScriptsHandler\RateLimiter;

enum ScriptContextRule: string
{
    public static function script(string $className): false|string
    {
        return match ($className) {
            CleanupUsersScript::class => file_get_contents(__DIR__.'/../Scripts/CleanupUsers.lua'),
            CreateUserScript::class => file_get_contents(__DIR__.'/../Scripts/CreateUser.lua'),
            RateLimiter::class => file_get_contents(__DIR__.'/../Scripts/RateLimiter.lua'),
        };
    }
}
