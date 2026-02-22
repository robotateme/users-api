<?php
declare(strict_types=1);

namespace Domains\User\ValueObjects\Read\ListUsers;

use Domains\User\ValueObjects\Exceptions\AvatarUriValueException;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class AvatarUri
{
    private string $value;

    /**
     * @param string|null $value
     * @throws AvatarUriValueException
     */
    public function __construct(?string $value)
    {
        try {
            Assert::string($value);
            Assert::notEmpty($value);
        } catch (InvalidArgumentException $argumentException) {
            throw new AvatarUriValueException(
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
