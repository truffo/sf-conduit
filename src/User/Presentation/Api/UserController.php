<?php

declare(strict_types=1);

namespace App\User\Presentation\Api;

use App\Shared\Presentation\AbstractApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractApiController
{
    /**
     * @Route("/user/register", name="user_register", methods={"POST"})
     */
    public function index(): Response
    {
        return $this->json([], Response::HTTP_CREATED);
    }
}
