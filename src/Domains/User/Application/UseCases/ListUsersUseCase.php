<?php

namespace Domains\User\Application\UseCases;

use Domains\User\Application\DTOs\UserDTO;
use Domains\User\Application\UseCases\Exceptions\UseCaseException;
use Domains\User\Infrastructure\Repositories\Redis\UserRedisReadRepository;
use Exception;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Instantiator;

final readonly class ListUsersUseCase
{
    public function __construct(private UserRedisReadRepository $userRedisRepository) {}

    /**
     * @throws UseCaseException
     */
    public function execute(): iterable
    {
        try {
            $listData = $this->userRedisRepository->list();
            return array_map(static function ($userData) {
                return Instantiator::instantiate(UserDTO::class, $userData);
            }, $listData);
        } catch (ExceptionInterface|Exception $e) {
            throw new UseCaseException($e->getMessage());
        }
    }
}
