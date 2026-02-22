<?php

declare(strict_types=1);

namespace Infrastructure\Repositories\Contracts;

use Infrastructure\Redis\RecordObjects\UserRecord;

interface UserRepositoryInterface
{
    public function list(): iterable;

    /**
     * @param  UserRecord  $dto
     */
    public function save(UserRecord $record): bool;
}
