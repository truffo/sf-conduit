<?php

declare(strict_types=1);

namespace App\User\Presentation\Api;

use App\Shared\Presentation\AbstractApiController;
use App\User\Application\Command\UserRegisterCommand;
use InvalidArgumentException;
use Nette\Utils\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

class UserController extends AbstractApiController
{
    /**
     * @Route("/user/register", name="user_register", methods={"POST"})
     */
    public function index(Request $request): Response
    {
        try {
            $data = Json::decode($request->getContent());
            Assert::propertyExists($data, 'user');

            $user = $data->user;
            Assert::propertyExists($user, 'password');
            Assert::propertyExists($user, 'email');
            Assert::propertyExists($user, 'username');
            Assert::email($user->email);

            $this->commandBus->dispatch(new UserRegisterCommand($user->username, $user->password, $user->email));
        } catch (InvalidArgumentException $exception) {
            return $this->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json([
            'user' => [
                'username' => 'string',
                'email' => 'email@toto.com',
                'token' => 'token',
                'bio' => 'bio',
                'image' => 'image',
            ]
        ], Response::HTTP_CREATED);
    }
}
