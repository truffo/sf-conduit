<?php

declare(strict_types=1);

namespace App\Shared\Presentation;

use App\Shared\Application\CQRS\CommandBus;
use App\Shared\Application\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractApiController extends AbstractController
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }
}
