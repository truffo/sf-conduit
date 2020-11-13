<?php

namespace App\Tests\Article\Domain;

use App\Article\Domain\ArticleRepositoryInterface;
use App\Article\Infrastructure\Repository\InMemory;
use App\Article\Infrastructure\Repository\Doctrine;
use App\Tests\ObjectMother\ArticleMother;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleRepositoryTest extends WebTestCase
{

    protected function setUp(): void
    {
        self::bootKernel();
   }

    /**
     * @return ArticleRepositoryInterface[]
     */
    public function articleRepositoryGenerator(): iterable
    {
        $registry = self::$container->get(ManagerRegistry::class);
        yield new InMemory\ArticleRepository();
        // yield new Doctrine\ArticleRepository($registry);
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
}
