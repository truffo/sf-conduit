<?php

namespace App\Tests\Article\Domain;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;
use App\Tests\ObjectMother\ArticleMother;
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
