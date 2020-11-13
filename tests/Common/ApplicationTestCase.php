<?php


namespace App\Tests\Common;

use App\Shared\Application\CQRS\CommandBus;
use App\Shared\Application\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApplicationTestCase extends KernelTestCase
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->commandBus = self::$container->get(CommandBus::class);
        $this->queryBus = self::$container->get(QueryBus::class);
    }
}