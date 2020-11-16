<?php

declare(strict_types=1);

namespace App\Tests\Article\Application\Command;

use App\Article\Application\Command\CreateArticleCommand;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Tests\Common\ApplicationTestCase;

final class CreateArticleCommandTest extends ApplicationTestCase
{
    public function testCreateArticle(): void
    {
        /** @var ArticleRepositoryInterface $repository */
        $repository = self::$container->get(ArticleRepositoryInterface::class);

        $command = CreateArticleCommand::create('title', 'description', 'body', ['tag1', 'tag2']);

        $this->commandBus->dispatch($command);

        $article = $repository->findByTitle('title');
        static::assertNotEmpty($article->getId());
        static::assertSame('title', $article->getTitle());
    }
}
