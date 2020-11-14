<?php


namespace App\Tests\ObjectMother;


use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;

class ArticleMother
{
    public const VALID_UUID = '23d35201-3abb-442c-a434-a88c622554d4';
    public const TITLE = 'Mon premier article';

    public static function anyWithUuid(string $uuid = self::VALID_UUID, string $title = self::TITLE): Article
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