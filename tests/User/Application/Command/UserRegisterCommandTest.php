<?php

declare(strict_types=1);

namespace App\Tests\User\Application\Command;

use App\Article\Application\Command\CreateArticleCommand;
use App\Article\Domain\ArticleRepositoryInterface;
use App\Tests\Common\ApplicationTestCase;
use App\User\Application\Command\UserRegisterCommand;
use App\User\Domain\UserRepositoryInterface;

final class UserRegisterCommandTest extends ApplicationTestCase
{
    public function testUserRegister(): void
    {
        $repository = self::$container->get(UserRepositoryInterface::class);

        $command = new UserRegisterCommand(
            'admin',
            'password',
            'admin@superproject.com'
        );

        $this->commandBus->dispatch($command);

        $user = $repository->findByUsername('admin');
        static::assertNotEmpty($user->getId());
        static::assertSame('admin@superproject.com', $user->getEmail());
    }
}
