<?php

namespace App\Console\Commands;

use Domains\User\Infrastructure\Redis\Scripts\RegisterUserScript;
use Illuminate\Console\Command;
use Illuminate\Contracts\Redis\Factory as RedisFactory;


class Testing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(RedisFactory $redisFactory)
    {
        dd(new RegisterUserScript($redisFactory->connection())->execute('test6663', '12'));
    }
}
