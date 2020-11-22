<?php


namespace App\Tests\User\Application\Query;


use App\Tests\Common\ApplicationTestCase;
use App\Tests\ObjectMother\UserMother;
use App\User\Application\Query\FindByUsernameHandler;
use App\User\Application\Query\FindByUsernameQuery;
use App\User\Domain\UserRepositoryInterface;

class FindByUsernameTest extends ApplicationTestCase
{
    public function testFindByUsername()
    {
        /** @var UserRepositoryInterface $repository */
        $repository = self::$container->get(UserRepositoryInterface::class);

        $repository->register(UserMother::anyWithUuid(UserMother::VALID_UUID));

        $query = new FindByUsernameQuery(UserMother::USERNAME);

        $handler = new FindByUsernameHandler($repository);
        $result = $handler($query);

        $value = $result->value();

        $this->assertIsArray($value);
        $this->assertArrayHasKey('user', $value);
        $this->assertIsArray($value['user']);
        $this->assertEquals(UserMother::USERNAME, $value['user']['username']);
    }
}