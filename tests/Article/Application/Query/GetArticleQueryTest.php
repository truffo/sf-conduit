<?php

declare(strict_types=1);

namespace App\Tests\Article\Application\Query;

use App\Article\Application\Query\GetArticleQuery;
use App\Article\Application\ViewModel\Article\ArticleViewModel;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Tests\Common\ApplicationTestCase;
use App\Tests\ObjectMother\ArticleMother;

final class GetArticleQueryTest extends ApplicationTestCase
{
    public function testGetArticle(): void
    {
        /** @var ArticleRepositoryInterface $repository */
        $repository = self::$container->get(ArticleRepositoryInterface::class);
        $repository->save(ArticleMother::anyWithUuid());

        $query = GetArticleQuery::create('article-1');

        $result = $this->queryBus->handle($query);

        static::assertInstanceOf(ArticleViewModel::class, $result);
        $value = $result->value();
        static::assertSame('article-1', $value['article']['slug']);
    }
}
