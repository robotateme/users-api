<?php

namespace Domains\User\ValueObjects;

use Domains\User\ValueObjects\Exceptions\Contracts\MetricValueException;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class Metric
{
    /**
     * @param int $value
     */
    private function __construct(
        private int $value
    ) {}

    /**
     * @param int $value
     * @return Metric
     * @throws MetricValueException
     */
    public static function fromInt(int $value): self
    {
        try {
            Assert::greaterThanEq($value, 0);

            return new self($value);

        } catch (InvalidArgumentException) {
            throw new MetricValueException('Metric value must be greater than 0.');
        }

    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param int $delta
     * @param int $max
     * @return self
     */
    public function increase(int $delta, int $max): self
    {
        return new self(min($this->value + $delta, $max));
    }

    /**
     * @param int $delta
     * @return self
     */
    public function decrease(int $delta): self
    {
        return new self(max(0, $this->value - $delta));
    }
}
