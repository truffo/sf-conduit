<?php

namespace App\Tests\Article\Domain;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Article\Infrastructure\Repository\InMemory;
use App\Article\Infrastructure\Repository\Doctrine;
use App\Tests\ObjectMother\ArticleMother;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleTest extends WebTestCase
{

    public function testArticleSlug()
    {
        $article = Article::create(
            new ArticleId(ArticleMother::VALID_UUID),
            'Titre avec des espaces',
            'Body'
        );

        $this->assertEquals('titre-avec-des-espaces', $article->getSlug());

    }
}
