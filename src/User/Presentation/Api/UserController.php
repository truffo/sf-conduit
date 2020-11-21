<?php

declare(strict_types=1);

namespace App\User\Presentation\Api;

use App\Shared\Presentation\AbstractApiController;
use App\User\Application\Command\UserRegisterCommand;
use App\User\Application\Query\FindByUsernameQuery;
use InvalidArgumentException;
use Nette\Utils\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Webmozart\Assert\Assert;

class UserController extends AbstractApiController
{
    /**
     * @Route("/users", name="user_register", methods={"POST"})
     */
    public function register(Request $request): Response
    {
        try {
            $data = Json::decode($request->getContent());
            Assert::propertyExists($data, 'user');

            $user = $data->user;
            Assert::propertyExists($user, 'password');
            Assert::propertyExists($user, 'email');
            Assert::propertyExists($user, 'username');
            Assert::email($user->email);

            $command = new UserRegisterCommand($user->username, $user->password, $user->email);
            $this->commandBus->dispatch($command);

            $viewModel = $this->queryBus->handle(new FindByUsernameQuery($user->username));
        } catch (InvalidArgumentException $exception) {
            return $this->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json($viewModel->value(), Response::HTTP_CREATED);
    }

    /**
     * @Route("/users/login", name="user_login", methods={"POST"})
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {


        return $this->json([]);
    }
}
