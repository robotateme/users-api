<?php

namespace Infrastructure\Redis\ScriptsHandler\Contracts;

use Infrastructure\Redis\ScriptsHandler\ScriptContextRule;
use Redis;

class AbstractScriptsHandler implements ScriptsHandlerInterface
{
    protected string $sha;

    public function __construct(protected readonly Redis $redis)
    {
        $script = ScriptContextRule::script(static::class);
        $this->sha = $this->redis->script('load', $script);
    }
}
