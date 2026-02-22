<?php

declare(strict_types=1);

namespace Domains\User\ValueObjects\Read\ListUsers;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

final class CreatedAt
{
    private string $format = 'Y-m-d H:i:s';

    public function __construct(private readonly DateTimeImmutable $value) {}

    /**
     * @param int $timestamp
     * @return CreatedAt
     */
    public static function fromTimestamp(int $timestamp): self
    {
        return new self(new DateTimeImmutable("@{$timestamp}"));
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format($this->format);
    }
}
