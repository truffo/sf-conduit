<?php

declare(strict_types=1);

namespace App\Tests\Article\Domain;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;
use App\Tests\ObjectMother\ArticleMother;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ArticleTest extends WebTestCase
{
    public function testArticleSlug(): void
    {
        $article = Article::create(new ArticleId(ArticleMother::VALID_UUID), 'Titre avec des espaces', 'Body');

        static::assertSame('titre-avec-des-espaces', $article->getSlug());
    }
}
