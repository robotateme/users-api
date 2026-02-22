<?php

declare(strict_types=1);

namespace Domains\User\ValueObjects\Read\ListUsers;

use Domains\User\ValueObjects\Exceptions\AvatarUrlValueException;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class AvatarUrl
{
    private readonly string $value;

    /**
     * @throws AvatarUrlValueException
     */
    public function __construct(AvatarUri $avatarUri, string $urn)
    {
        try {
            Assert::notEmpty($urn);
            Assert::startsWith($urn, 'http');
            $this->value = $this->buildUrl($urn, $avatarUri->getValue());
        } catch (InvalidArgumentException $exception) {
            throw new AvatarUrlValueException($exception->getMessage(), previous: $exception);
        }
    }

    private function buildUrl(string $base, string $uri): string
    {
        $base = rtrim($base, '/');
        $uri = ltrim($uri, '/');

        return $base.'/'.$uri;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
