<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Repository\InMemory;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;
use App\Article\Domain\ArticleRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class ArticleRepository implements ArticleRepositoryInterface
{
    private ArrayCollection $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function findByTitle(string $title): Article
    {
        $result = $this->data->filter(fn (Article $article) => $article->getTitle() === $title);
        if ($result->count() === 0) {
            throw new InvalidArgumentException();
        }
        return $result->first();
    }

    public function save(Article $article): void
    {
        $this->data->add($article);
    }

    public function nextId(): ArticleId
    {
        return ArticleId::fromString(Uuid::uuid4()->toString());
    }

    public function findByUuid(string $uuid): Article
    {
        $result = $this->data->filter(fn (Article $article) => $article->getId()->value() === $uuid);
        if ($result->count() === 0) {
            throw new InvalidArgumentException();
        }
        return $result->first();
    }
}
