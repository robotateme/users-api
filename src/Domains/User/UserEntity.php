<?php
declare(strict_types=1);

namespace Domains\User;

use Domains\User\ValueObjects\AvatarUri;
use Domains\User\ValueObjects\CreatedAt;
use Domains\User\ValueObjects\Nickname;

final readonly class UserEntity
{
    /**
     * @param Nickname $nickname
     * @param AvatarUri $avatarUri
     * @param CreatedAt $createdAt
     */
    public function __construct(
        private Nickname $nickname,
        private AvatarUri $avatarUri,
        private CreatedAt $createdAt,
    ) {}

    /**
     * @param Nickname $nickname
     * @param AvatarUri $avatarUri
     * @param CreatedAt $createdAt
     * @return self
     */
    public static function register(
        Nickname $nickname,
        AvatarUri $avatarUri,
        CreatedAt $createdAt
    ): self {
        return new self($nickname, $avatarUri, $createdAt);
    }

    /**
     * @return Nickname
     */
    public function getNickname(): Nickname
    {
        return $this->nickname;
    }

    /**
     * @return AvatarUri
     */
    public function getAvatarUri(): AvatarUri
    {
        return $this->avatarUri;
    }

    /**
     * @return CreatedAt
     */
    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }
}
