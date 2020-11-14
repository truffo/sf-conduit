<?php

namespace App\Tests\Article\Application\Query;

use App\Article\Application\Query\GetArticleQuery;
use App\Article\Application\ViewModel\Article\ArticleViewModel;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Tests\Common\ApplicationTestCase;
use App\Tests\ObjectMother\ArticleMother;

class GetArticleQueryTest extends ApplicationTestCase
{
    public function testGetArticle()
    {
        /** @var ArticleRepositoryInterface $repository */
        $repository = self::$container->get(ArticleRepositoryInterface::class);
        $repository->save(ArticleMother::anyWithUuid());

        $query = GetArticleQuery::create('article-1');

        $result = $this->queryBus->handle($query);

        $this->assertInstanceOf(ArticleViewModel::class, $result);
        $value = $result->value();
        $this->assertEquals('article-1', $value['article']['slug']);
    }
}
