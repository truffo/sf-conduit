<?php

declare(strict_types=1);

namespace App\User\Presentation\Api;

use App\Shared\Application\CQRS\CommandBus;
use App\Shared\Application\CQRS\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private CommandBus $commandBus;

    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/user/register", name="user_register", methods={"POST"})
     */
    public function index(): Response
    {
        return $this->json([], Response::HTTP_CREATED);
    }
}
