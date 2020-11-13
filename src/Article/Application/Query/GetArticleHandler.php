<?php

declare(strict_types=1);

namespace App\Article\Application\Query;

use App\Article\Application\ViewModel\Article\ArticleViewModel;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Shared\Application\CQRS\QueryHandler;

final class GetArticleHandler implements QueryHandler
{
    private ArticleRepositoryInterface $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetArticleQuery $query)
    {
        $article = $this->repository->findBySlug($query->getSlug());

        return new ArticleViewModel(
            $article->getSlug(),
            $article->getTitle(),
            $article->getDescription(),
            $article->getBody(),
            $article->getTagList(),
            $article->getCreatedAt(),
            $article->getUpdatedAt(),
            $article->isFavorited(),
            $article->getFavoritesCount()
        );
    }
}
