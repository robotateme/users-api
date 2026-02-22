<?php
declare(strict_types=1);

namespace Domains\User;

use Domains\User\ValueObjects\Read\ListUsers\AvatarUri;
use Domains\User\ValueObjects\Read\ListUsers\CreatedAt;
use Domains\User\ValueObjects\Write\Nickname;

final readonly class UserEntity
{
    public function __construct(
        private Nickname $nickname,
        private AvatarUri $avatarUri,
        private CreatedAt $createdAt,
    ) {}

    public static function register(
        Nickname $nickname,
        AvatarUri $avatarUri,
        CreatedAt $createdAt
    ): self {
        return new self($nickname, $avatarUri, $createdAt);
    }

    public function getNickname(): Nickname
    {
        return $this->nickname;
    }

    public function getAvatarUri(): AvatarUri
    {
        return $this->avatarUri;
    }

    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }
}
