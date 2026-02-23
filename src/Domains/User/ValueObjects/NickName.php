<?php
declare(strict_types=1);

namespace Domains\User\ValueObjects;

use Domains\User\ValueObjects\Exceptions\NicknameValueException;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class NickName
{
    private string $value;

    /**
     * @param string|null $value
     * @throws NicknameValueException
     */
    public function __construct(?string $value)
    {
        try {
            Assert::string($value);
            Assert::notEmpty($value);
        } catch (InvalidArgumentException $argumentException) {
            throw new NicknameValueException(
                $argumentException->getMessage(),
                previous: $argumentException,
            );
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
