<?php

declare(strict_types=1);

namespace Domains\User;

use Domains\User\Enum\RanksEnum;
use Domains\User\Services\UserRankPolicyService;
use Domains\User\ValueObjects\AvatarUri;
use Domains\User\ValueObjects\CreatedAt;
use Domains\User\ValueObjects\Metric;
use Domains\User\ValueObjects\Nickname;

final class UserEntity
{
    public function __construct(
        private readonly Nickname $nickname,
        private readonly AvatarUri $avatarUri,
        private Metric $metric,
        private RanksEnum $rank,
        private readonly CreatedAt $createdAt,
        private ?int $penaltyCap = null,
    ) {}

    public static function register(
        Nickname $nickname,
        AvatarUri $avatarUri,
        Metric $metric,
        RanksEnum $rank,
        CreatedAt $createdAt,
        ?int $penaltyCap = null
    ): self {
        return new self($nickname, $avatarUri, $metric, $rank, $createdAt, $penaltyCap);
    }

    public function applyMerit(int $value): void
    {
        $max = UserRankPolicyService::maxAllowedFor($this->rank, $this->penaltyCap);

        $this->metric = $this->metric->increase($value, $max);
        $this->rank = UserRankPolicyService::determineRank($this->metric);
    }

    public function applyPenalty(int $value, int $newCap): void
    {
        $this->metric = $this->metric->decrease($value);
        $this->penaltyCap = $newCap;
        $this->rank = UserRankPolicyService::determineRank($this->metric);
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

    public function getMetric(): Metric
    {
        return $this->metric;
    }

    public function getRank(): RanksEnum
    {
        return $this->rank;
    }

    public function getPenaltyCap(): ?int
    {
        return $this->penaltyCap;
    }
}
