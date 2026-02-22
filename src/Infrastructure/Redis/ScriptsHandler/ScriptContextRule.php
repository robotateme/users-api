<?php

namespace Infrastructure\Redis\ScriptsHandler;

enum ScriptContextRule: string
{
    public static function script(string $className): false|string
    {
        return match ($className) {
            CleanupUsersScript::class => file_get_contents(__DIR__.'/Scripts/CleanupUsers.lua'),
            CreateUserScript::class => file_get_contents(__DIR__.'/Scripts/CreateUser.lua'),
        };
    }
}
