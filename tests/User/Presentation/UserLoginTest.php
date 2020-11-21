<?php

declare(strict_types=1);

namespace App\Tests\User\Presentation;

use App\Tests\Common\PresentationTestCase;
use App\User\Domain\User;
use App\User\Domain\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserLoginTest extends PresentationTestCase
{
    public static string $jsonSchemaUserLogin = <<<'CODE_SAMPLE'
    {
        "allOf": [
            {
              "$ref": "#/definitions/LoginUserRequest"
            }
        ],
        "definitions": {
            "LoginUserRequest": {
                "type": "object",
                "properties": {
                    "user": {
                        "$ref": "#/definitions/LoginUser"
                    }
                },
                "required": [
                    "user"
                ]
            },
            "LoginUser": {
                "type": "object",
                "properties": {
                    "email": {
                      "type": "string"
                    },
                    "password": {
                      "type": "string",
                      "format": "password"
                    }
                },
                "required": [
                    "email",
                    "password"
                ]
            }
        }
    }
    CODE_SAMPLE;


    public function testUserLogin(): void
    {
        /** @var UserPasswordEncoderInterface $passwordEncoder */
        $passwordEncoder = static::$container->get(UserPasswordEncoderInterface::class);
        /** @var UserRepositoryInterface $repo */
        $repo = static::$container->get(UserRepositoryInterface::class);
        $user = new User($repo->nextId(), 'toto@gmail.com', 'toto');
        $user->setPassword($passwordEncoder->encodePassword($user, 'password'));
        $repo->register($user);

        $this->sendPost('/users/login', [
            'user' => [
                'email' => 'toto@example.com',
                'password' => 'password',
            ],
        ]);
        $response = $this->client->getResponse();

        static::assertResponseStatusCodeSame(Response::HTTP_OK);
        static::assertJson($response->getContent());
        static::assertJsonMatchSchemaString($response->getContent(), self::$jsonSchemaUserLogin);
    }

    /*
    public function testUserLoginBadPassword(): void
    {
        $this->sendPost('/users/login', [
            'user' => [
                'email' => 'toto@example.com',
                'password' => 'badpassword',
            ],
        ]);
        $response = $this->client->getResponse();

        static::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
    */
}
