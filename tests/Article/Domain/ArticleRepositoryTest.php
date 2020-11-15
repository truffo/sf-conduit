<?php

declare(strict_types=1);

namespace App\Tests\Article\Domain;

use App\Article\Infrastructure\Repository\Doctrine;
use App\Article\Infrastructure\Repository\InMemory;
use App\Tests\ObjectMother\ArticleMother;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Ramsey\Uuid\Rfc4122\Validator;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ArticleRepositoryTest extends WebTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities();
    }

    /**
     * @return array<class-name>
     */
    public function articleRepositoryProvider(): array
    {
        return [[InMemory\ArticleRepository::class], [Doctrine\ArticleRepository::class]];
    }

    /**
     * @dataProvider articleRepositoryProvider
     *
     * @param mixed $class
     */
    public function testSave($class): void
    {
        $repo = self::$container->get($class);
        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);

        $repo->save($article);
        $result = $repo->findByUuid(ArticleMother::VALID_UUID);
        static::assertSame($article, $result);
    }

    /**
     * @dataProvider articleRepositoryProvider
     *
     * @param mixed $class
     */
    public function testNextId($class): void
    {
        $repo = self::$container->get($class);

        static::assertTrue((new Validator())->validate($repo->nextId()->value()));
    }

    /**
     * @dataProvider articleRepositoryProvider
     *
     * @param mixed $class
     */
    public function testFindByTitle($class): void
    {
        $repo = self::$container->get($class);

        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        $repo->save($article);
        $result = $repo->findByTitle(ArticleMother::TITLE);
        static::assertSame($article, $result);
    }

    /**
     * @dataProvider articleRepositoryProvider
     *
     * @param mixed $class
     */
    public function testFindByTitleNonExistantTitle($class): void
    {
        $repo = self::$container->get($class);

        $this->expectException(InvalidArgumentException::class);
        $repo->findByTitle('Non existent title');
    }

    /**
     * @dataProvider articleRepositoryProvider
     *
     * @param mixed $class
     */
    public function testFindBySlug($class): void
    {
        $repo = self::$container->get($class);

        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        $repo->save($article);
        $result = $repo->findBySlug('article-1');
        static::assertSame($article, $result);
    }

    /**
     * @dataProvider articleRepositoryProvider
     *
     * @param mixed $class
     */
    public function testFindBySlugNonExistantSlug($class): void
    {
        $repo = self::$container->get($class);

        $this->expectException(InvalidArgumentException::class);
        $repo->findBySlug('Non existent slug');
    }

    /**
     * @dataProvider articleRepositoryProvider
     *
     * @param mixed $class
     */
    public function testFindByUuid($class): void
    {
        $repo = self::$container->get($class);

        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        $repo->save($article);
        $result = $repo->findByUuid(ArticleMother::VALID_UUID);
        static::assertSame($article, $result);
    }

    /**
     * @dataProvider articleRepositoryProvider
     *
     * @param mixed $class
     */
    public function testFindByUuidNonExistantUuid($class): void
    {
        $repo = self::$container->get($class);

        $this->expectException(InvalidArgumentException::class);
        $repo->findByUuid(Uuid::uuid4()->toString());
    }

    private function truncateEntities(): void
    {
        $purger = new ORMPurger(self::$container->get(EntityManagerInterface::class));
        $purger->purge();
    }
}
