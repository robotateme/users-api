<?php

namespace Application\UseCases;

use Application\Commands\UserRegistrationCommand;
use Application\UseCases\Exceptions\ApplicationException;
use Application\UseCases\Exceptions\NicknameAlreadyExists;
use Domains\User\Services\UserRankPolicyService;
use Domains\User\UserEntity;
use Domains\User\ValueObjects\AvatarUri;
use Domains\User\ValueObjects\CreatedAt;
use Domains\User\ValueObjects\Exceptions\Contracts\UserValueException;
use Domains\User\ValueObjects\Metric;
use Domains\User\ValueObjects\NickName;
use Infrastructure\Providers\Contracts\TimeProviderInterface;
use Infrastructure\Repositories\Contracts\UserRepositoryInterface;

class UserRegistrationUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly TimeProviderInterface $clock,
    ) {}

    /**
     * @param UserRegistrationCommand $userRegistrationCommand
     * @return bool
     * @throws ApplicationException
     * @throws NicknameAlreadyExists
     */
    public function execute(UserRegistrationCommand $userRegistrationCommand): bool
    {
        try {
            $userEntity = UserEntity::register(
                nickname: new Nickname($userRegistrationCommand->nickname),
                avatarUri: new AvatarUri($userRegistrationCommand->avatarUri),
                metric: Metric::fromInt($userRegistrationCommand->metric),
                rank: UserRankPolicyService::determineRank(Metric::fromInt($userRegistrationCommand->metric)),
                createdAt: CreatedAt::fromTimestamp($this->clock->now())
            );

            if (! $this->userRepository->register($userEntity)) {
                throw new NicknameAlreadyExists;
            }

            return true;

        } catch (UserValueException $exception) {
            throw new ApplicationException($exception->getMessage(), previous: $exception);
        }
    }
}
