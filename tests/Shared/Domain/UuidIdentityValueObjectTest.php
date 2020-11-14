<?php

namespace App\Tests\Shared\Domain;

use App\Shared\Domain\ValueObject\UuidIdentityValueObject;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class UuidIdentityValueObjectTest extends TestCase
{
    public function testConstruct()
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(666);
        $uuid = $faker->uuid;
        $vo = UuidIdentityValueObject::fromString($uuid);

        $this->assertEquals($uuid, $vo->value());
        $this->assertEquals($uuid, $vo->__toString());
    }

    public function testConstructNoUuidType()
    {
        $this->expectException(\Assert\InvalidArgumentException::class);
        new UuidIdentityValueObject('bobo');
    }

    public function testConstructNoUuidString()
    {
        $this->expectException(\Assert\InvalidArgumentException::class);
        UuidIdentityValueObject::fromString('bobo');
    }

    public function testEquals()
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(666);
        $uuid = $faker->uuid;
        $vo1 = UuidIdentityValueObject::fromString($uuid);
        $vo2 = new UuidIdentityValueObject($uuid);

        $this->assertTrue($vo1->equals($vo2));
        $this->assertTrue($vo2->equals($vo1));
        $this->assertEquals($vo2, $vo1);
    }
}
