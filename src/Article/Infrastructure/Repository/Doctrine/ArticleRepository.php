<?php

declare(strict_types=1);

namespace App\Article\Infrastructure\Repository\Doctrine;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;
use App\Article\Domain\ArticleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

final class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $article): void
    {
        $this->_em->persist($article);
        $this->_em->flush();
    }

    public function findByTitle(string $title): Article
    {
        return $this->findOneBy([
            'title' => $title,
        ]);
    }

    public function nextId(): ArticleId
    {
        return ArticleId::fromString(Uuid::uuid4()->toString());
    }

    public function findByUuid(string $uuid): Article
    {
        return $this->findOneBy([
            'id' => $uuid,
        ]);
    }

    public function findBySlug(string $slug): Article
    {
        return $this->findOneBy([
            'slug' => $slug,
        ]);
    }
}
