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
        $uuid = '23d35201-3abb-442c-a434-a88c622554d4';
        $article = ArticleMother::anyWithUuid($uuid);
        foreach ($this->articleRepositoryGenerator() as $repo) {
            $repo->save($article);
            $result = $repo->findByUuid($uuid);
            $this->assertSame($article, $result);
        }
    }
}
