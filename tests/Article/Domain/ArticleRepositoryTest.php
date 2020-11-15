<?php

namespace App\Tests\Article\Domain;

use App\Article\Domain\ArticleRepositoryInterface;
use App\Article\Infrastructure\Repository\Doctrine;
use App\Article\Infrastructure\Repository\InMemory;
use App\Tests\ObjectMother\ArticleMother;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Rfc4122\Validator;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleRepositoryTest extends WebTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities();
    }

    private function truncateEntities()
    {
        $purger = new ORMPurger(self::$container->get(EntityManagerInterface::class));
        $purger->purge();
    }

    /**
     * @return array<class-name>
     */
    public function articleRepositoryProvider(): array
    {
        return [
            [InMemory\ArticleRepository::class],
            [Doctrine\ArticleRepository::class]
        ];
    }

    /**
     * @dataProvider articleRepositoryProvider
     */
    public function testSave($class)
    {
        $repo = self::$container->get($class);
        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);

        $repo->save($article);
        $result = $repo->findByUuid(ArticleMother::VALID_UUID);
        $this->assertSame($article, $result);
    }

    /**
     * @dataProvider articleRepositoryProvider
     */
    public function testNextId($class)
    {
        $repo = self::$container->get($class);

        $this->assertTrue((new Validator())->validate($repo->nextId()->value()));
    }

    /**
     * @dataProvider articleRepositoryProvider
     */
    public function testFindByTitle($class)
    {
        $repo = self::$container->get($class);

        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        $repo->save($article);
        $result = $repo->findByTitle(ArticleMother::TITLE);
        $this->assertSame($article, $result);
    }

    /**
     * @dataProvider articleRepositoryProvider
     */
    public function testFindByTitleNonExistantTitle($class)
    {
        $repo = self::$container->get($class);

        $this->expectException(\InvalidArgumentException::class);
        $repo->findByTitle('Non existent title');
    }


    /**
     * @dataProvider articleRepositoryProvider
     */
    public function testFindBySlug($class)
    {
        $repo = self::$container->get($class);

        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        $repo->save($article);
        $result = $repo->findBySlug('article-1');
        $this->assertSame($article, $result);
    }


    /**
     * @dataProvider articleRepositoryProvider
     */
    public function testFindBySlugNonExistantSlug($class)
    {
        $repo = self::$container->get($class);

        $this->expectException(\InvalidArgumentException::class);
        $repo->findBySlug('Non existent slug');
    }


    /**
     * @dataProvider articleRepositoryProvider
     */
    public function testFindByUuid($class)
    {
        $repo = self::$container->get($class);

        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        $repo->save($article);
        $result = $repo->findByUuid(ArticleMother::VALID_UUID);
        $this->assertSame($article, $result);
    }

    /**
     * @dataProvider articleRepositoryProvider
     */
    public function testFindByUuidNonExistantUuid($class)
    {
        $repo = self::$container->get($class);

        $this->expectException(\InvalidArgumentException::class);
        $repo->findByUuid(Uuid::uuid4()->toString());
    }
}
