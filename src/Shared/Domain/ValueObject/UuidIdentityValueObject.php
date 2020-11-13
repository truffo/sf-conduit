<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Assert\Assertion;

class UuidIdentityValueObject implements IdentityValueObject
{
    protected string $value;

    final public function __construct(string $value)
    {
        Assertion::uuid($value);

        $this->value = $value;
    }

    final public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @return static
     */
    public static function fromString(string $value)
    {
        return new static($value);
    }

    final public function value(): string
    {
        return $this->value;
    }

    final public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }
}
