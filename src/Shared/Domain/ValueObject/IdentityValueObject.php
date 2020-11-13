<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

interface IdentityValueObject
{
    public function __toString(): string;

    public function value(): string;
}
