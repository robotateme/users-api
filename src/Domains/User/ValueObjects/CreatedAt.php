<?php

declare(strict_types=1);

namespace Domains\User\ValueObjects;

use DateTimeImmutable;

final class CreatedAt
{
    private string $format = 'Y-m-d H:i:s';

    /**
     * @param DateTimeImmutable $value
     */
    public function __construct(private readonly DateTimeImmutable $value) {}

    /**
     * @param int $timestamp
     * @return CreatedAt
     */
    public static function fromTimestamp(int $timestamp): self
    {
        return new self(new DateTimeImmutable("@{$timestamp}"));
    }

    /**
     * @return DateTimeImmutable
     */
    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value->format($this->format);
    }
}
