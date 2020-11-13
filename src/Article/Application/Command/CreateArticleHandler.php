<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Shared\Application\CQRS\CommandHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateArticleHandler implements CommandHandler
{
    private ArticleRepositoryInterface $articleRepository;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        ArticleRepositoryInterface $articleRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->articleRepository = $articleRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateArticleCommand $command): void
    {
        $article = Article::create(
            $this->articleRepository->nextId(),
            $command->getTitle(),
            $command->getBody(),
            $command->getDescription(),
            $command->getTags()
        );
        $this->articleRepository->save($article);
        $this->eventDispatcher->dispatch($command, CreateArticleCommand::class);
    }
}
