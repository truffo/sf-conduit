<?php

namespace App\Tests\Article\Application;

use App\Article\Application\Command\CreateArticleCommand;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Shared\Application\CQRS\CommandBus;
use App\Shared\Application\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateArticleCommandTest extends WebTestCase
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->commandBus = self::$container->get(CommandBus::class);
        $this->queryBus = self::$container->get(QueryBus::class);
    }

    public function testCreateArticle()
    {
        /** @var ArticleRepositoryInterface $repository */
        $repository = self::$container->get(ArticleRepositoryInterface::class);

        $command = CreateArticleCommand::create(
            "title",
            "description",
            "body",
            ["tag1", "tag2"]
        );

        $this->commandBus->dispatch($command);

        $article = $repository->findByTitle('title');
        $this->assertNotEmpty($article->getId());
        $this->assertEquals('title', $article->getTitle());
    }
}
