<?php

declare(strict_types=1);

namespace App\Article\Domain;

interface ArticleRepositoryInterface
{
    public function nextId(): ArticleId;

    public function findByUuid(string $title): Article;

    public function findByTitle(string $title): Article;

    public function save(Article $article);
}
