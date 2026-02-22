<?php

namespace Application\UseCases;

use Application\Commands\UserRegistrationCommand;
use Application\UseCases\Exceptions\ApplicationException;
use Application\UseCases\Exceptions\NicknameAlreadyExists;
use Domains\User\Exceptions\Contracts\UserDomainException;
use Domains\User\UserEntity;
use Domains\User\ValueObjects\AvatarUri;
use Domains\User\ValueObjects\CreatedAt;
use Domains\User\ValueObjects\Exceptions\Contracts\UserValueException;
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
     * @param UserRegistrationCommand $userRegistrationDTO
     * @return bool
     * @throws ApplicationException
     * @throws NicknameAlreadyExists
     */
    public function execute(UserRegistrationCommand $userRegistrationDTO): bool
    {
        try {
            $userEntity = UserEntity::register(
                nickname: new Nickname($userRegistrationDTO->nickname),
                avatarUri: new AvatarUri($userRegistrationDTO->avatarUri),
                createdAt: CreatedAt::fromTimestamp($this->clock->now()),
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
