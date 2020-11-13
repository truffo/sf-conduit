<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Repository\Doctrine;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;
use App\Article\Domain\ArticleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findByTitle(string $title): Article
    {
        // TODO: Implement findByTitle() method.
    }

    public function save(Article $article): void
    {
        // TODO: Implement save() method.
    }

    public function nextId(): ArticleId
    {
        // TODO: Implement nextId() method.
    }

    public function findByUuid(string $title): Article
    {
        // TODO: Implement findByUuid() method.
    }
}
