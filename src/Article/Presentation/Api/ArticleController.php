<?php

declare(strict_types=1);

namespace App\Article\Presentation\Api;

use App\Article\Application\Command\CreateArticleCommand;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Shared\Application\CQRS\CommandBus;
use App\Shared\Application\CQRS\QueryBus;
use App\Shared\Presentation\AbstractApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractApiController
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        ArticleRepositoryInterface $articleRepository
    ) {
        parent::__construct($commandBus, $queryBus);

        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/articles", name="article_presentation_articles")
     */
    public function index(): Response
    {
        $createArticleCommand = CreateArticleCommand::create('title', 'description', 'body', ['tag1', 'tag2']);

        $this->commandBus->dispatch($createArticleCommand);

        return $this->json([]);
    }
}
