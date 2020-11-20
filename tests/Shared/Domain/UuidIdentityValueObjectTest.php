<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Shared\Domain\ValueObject\UuidIdentityValueObject;
use Assert\InvalidArgumentException;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class UuidIdentityValueObjectTest extends TestCase
{
    public function testConstruct(): void
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(666);
        $uuid = $faker->uuid;
        $vo = UuidIdentityValueObject::fromString($uuid);

        static::assertSame($uuid, $vo->value());
        static::assertSame($uuid, $vo->__toString());
    }

    public function testConstructNoUuidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new UuidIdentityValueObject('bobo');
    }

    public function testConstructNoUuidString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UuidIdentityValueObject::fromString('bobo');
    }

    public function testEquals(): void
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(666);
        $uuid = $faker->uuid;
        $vo1 = UuidIdentityValueObject::fromString($uuid);
        $vo2 = new UuidIdentityValueObject($uuid);

        static::assertTrue($vo1->equals($vo2));
        static::assertTrue($vo2->equals($vo1));
        static::assertEquals($vo2, $vo1);
    }
}
