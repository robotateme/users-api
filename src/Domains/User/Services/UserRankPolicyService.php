<?php

namespace Domains\User\Services;

use Domains\User\Enum\RanksEnum;
use Domains\User\ValueObjects\Metric;

final class UserRankPolicyService
{
    /**
     * @param Metric $metric
     * @return RanksEnum
     */
    public static function determineRank(Metric $metric): RanksEnum
    {
        return match (true) {
            $metric->value() >= 60 => RanksEnum::ALPHA,
            $metric->value() >= 30 => RanksEnum::SIGMA,
            default => RanksEnum::OMEGA,
        };
    }

    /**
     * @param RanksEnum $rank
     * @param int|null $penaltyCap
     * @return int
     */
    public static function maxAllowedFor(
        RanksEnum $rank,
        ?int $penaltyCap
    ): int {
        $baseMax = match ($rank) {
            RanksEnum::ALPHA => 100,
            RanksEnum::SIGMA => 60,
            RanksEnum::OMEGA => 30,
        };

        return $penaltyCap !== null
            ? min($baseMax, $penaltyCap)
            : $baseMax;
    }
}
