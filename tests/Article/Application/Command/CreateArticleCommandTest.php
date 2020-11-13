<?php

namespace App\Tests\Article\Application\Command;

use App\Article\Application\Command\CreateArticleCommand;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Shared\Application\CQRS\CommandBus;
use App\Shared\Application\CQRS\QueryBus;
use App\Tests\Common\ApplicationTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateArticleCommandTest extends ApplicationTestCase
{
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
