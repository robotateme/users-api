<?php

declare(strict_types=1);

namespace Application\UseCases;

use Application\DTOs\UserReadDTO;
use Application\UseCases\Exceptions\ApplicationException;
use ArrayIterator;
use Domains\User\ValueObjects\AvatarUri;
use Domains\User\ValueObjects\AvatarUrl;
use Domains\User\ValueObjects\CreatedAt;
use Domains\User\ValueObjects\Exceptions\Contracts\UserValueException;
use Infrastructure\Providers\LaravelAppUrlProvider;
use Infrastructure\Redis\RecordObjects\UserRecord;
use Infrastructure\Repositories\Contracts\UserRepositoryInterface;

class ListUsersUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly LaravelAppUrlProvider   $appUrlProvider,
    ) {}

    /**
     * @throws ApplicationException
     */
    public function execute(): iterable
    {
        $resultCollection = new ArrayIterator;
        /** @var UserRecord $userRecord */
        foreach ($this->userRepository->list() as $userRecord) {
            try {
                $resultCollection->append(new UserReadDTO(
                    nickname: $userRecord->nickname,
                    avatar: (string) new AvatarUrl(new AvatarUri($userRecord->avatar), $this->appUrlProvider->getAppUrl()),
                    created_at: (string) CreatedAt::fromTimestamp((int) $userRecord->createdAt),
                ));
            } catch (UserValueException $e) {
                throw new ApplicationException($e->getMessage());
            }
        }

        return $resultCollection->getArrayCopy();
    }
}
