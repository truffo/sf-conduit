<?php

namespace App\Tests\Article\Domain;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Article\Infrastructure\Repository\InMemory;
use App\Article\Infrastructure\Repository\Doctrine;
use App\Tests\ObjectMother\ArticleMother;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Generator;
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
     * @return ArticleRepositoryInterface[]
     */
    public function articleRepositoryGenerator(): iterable
    {
        $registry = self::$container->get(ManagerRegistry::class);
        yield new InMemory\ArticleRepository();
        yield new Doctrine\ArticleRepository($registry);
    }

    public function testSave()
    {
        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $repo->save($article);
            $result = $repo->findByUuid(ArticleMother::VALID_UUID);
            $this->assertSame($article, $result);
        }
    }

    public function testNextId()
    {
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $this->assert$repo->nextId()
        }
    }

    public function testFindByTitle()
    {
        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $repo->save($article);
            $result = $repo->findByTitle(ArticleMother::TITLE);
            $this->assertSame($article, $result);
        }
    }

    public function testFindByTitleNonExistantTitle()
    {
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $this->expectException(\InvalidArgumentException::class);
            $repo->findByTitle('Non existent title');
        }
    }

    public function testFindBySlug()
    {
        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $repo->save($article);
            $result = $repo->findBySlug('article-1');
            $this->assertSame($article, $result);
        }
    }

    public function testFindBySlugNonExistantSlug()
    {
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $this->expectException(\InvalidArgumentException::class);
            $repo->findBySlug('Non existent slug');
        }
    }

    public function testFindByUuid()
    {
        $article = ArticleMother::anyWithUuid(ArticleMother::VALID_UUID);
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $repo->save($article);
            $result = $repo->findByUuid(ArticleMother::VALID_UUID);
            $this->assertSame($article, $result);
        }
    }

    public function testFindByUuidNonExistantUuid()
    {
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $this->expectException(\InvalidArgumentException::class);
            $repo->findByUuid(Uuid::uuid4()->toString());
        }
    }
}
