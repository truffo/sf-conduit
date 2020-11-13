<?php

declare(strict_types=1);

namespace App\Article\Presentation;

use App\Article\Application\Command\CreateArticleCommand;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Shared\Application\CQRS\CommandBus;
use App\Shared\Application\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private CommandBus $commandBus;

    private QueryBus $queryBus;

    private ArticleRepositoryInterface $articleRepository;

    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        ArticleRepositoryInterface $articleRepository
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/articles", name="article_presentation_articles")
     */
    public function index(): Response
    {
        $createArticleCommand = CreateArticleCommand::create('title', 'description', 'body', ['tag1', 'tag2']);

        $this->commandBus->dispatch($createArticleCommand);
        // $this->queryBus->handle();

        return $this->json([]);

        return $this->json([
            'articles' => [
                0 => [
                    'slug' => 'string',
                    'title' => 'string',
                    'description' => 'string',
                    'body' => 'string',
                    'tagList' => [
                        0 => 'string',
                    ],
                    'createdAt' => '2020-11-05T22:27:36.320Z',
                    'updatedAt' => '2020-11-05T22:27:36.320Z',
                    'favorited' => true,
                    'favoritesCount' => 0,
                    'author' => [
                        'username' => 'string',
                        'bio' => 'string',
                        'image' => 'string',
                        'following' => true,
                    ],
                ],
            ],
            'articlesCount' => 0,
        ]);
    }
}
