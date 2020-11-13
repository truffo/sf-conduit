<?php


namespace App\Tests\ObjectMother;


use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;

class ArticleMother
{
    public static function anyWithUuid(string $uuid): Article
    {
        return new Article(
            ArticleId::fromString($uuid),
            'article-1',
            'Mon premier article',
            'Description de mon premier article',
            'Body de mon premier article',
            ['tag 1', 'tag 2', 'tag 3'],
            false,
            0
        );
    }
}