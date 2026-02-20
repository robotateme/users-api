<?php

namespace Domains\User\Infrastructure\Repositories\Contracts;

interface UserReadRepositoryInterface
{
    /**
     * @return iterable
     */
    public function list(): iterable;
}
