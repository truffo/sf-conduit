<?php


namespace App\Tests\User\Domain;


use App\Tests\ObjectMother\ArticleMother;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Rfc4122\Validator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\User\Infrastructure\Repository\InMemory;

class UserRepositoryTest extends WebTestCase
{

    protected function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities();
    }

    /**
     * @return array<class-name|string>
     */
    public function repositoryProvider(): array
    {
        return [
            [InMemory\UserRepository::class]
        ];
    }

    /**
     * @dataProvider repositoryProvider
     *
     * @param class-name|string $class
     */
    public function testNextId($class): void
    {
        $repo = self::$container->get($class);

        static::assertTrue((new Validator())->validate($repo->nextId()->value()));
    }

    /**
     * @dataProvider repositoryProvider
     *
     * @param mixed $class
     */
    public function testFindByUsername($class): void
    {
    }

    private function truncateEntities(): void
    {
        $purger = new ORMPurger(self::$container->get(EntityManagerInterface::class));
        $purger->purge();
    }
}