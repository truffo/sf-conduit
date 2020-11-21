<?php

declare(strict_types=1);

namespace App\Tests\User\Presentation;

use App\Tests\Common\PresentationTestCase;
use Symfony\Component\HttpFoundation\Response;

final class UseRegisterTest extends PresentationTestCase
{
    public static string $jsonSchemaUserRegister = <<<'CODE_SAMPLE'
    {
        "allOf": [
            {
                "$ref": "#/definitions/UserResponse"
            }
        ],
        "definitions": {
            "UserResponse": {
                "type": "object",
                "properties": {
                    "user": {
                      "$ref": "#/definitions/User"
                    }
                },
                "required": [
                    "user"
                ]
            },
            "User": {
                "type": "object",
                "properties": {
                    "email": {
                      "type": "string"
                    },
                    "token": {
                      "type": "string"
                    },
                    "username": {
                      "type": "string"
                    },
                    "bio": {
                      "type": "string"
                    },
                    "image": {
                      "type": "string"
                    }
                },
                "required": [
                    "email",
                    "token",
                    "username",
                    "bio",
                    "image"
                ]
            }
        }
    }
    CODE_SAMPLE;

    public function testUserRegister(): void
    {
        $this->sendPost('/users', [
            'user' => [
                'username' => 'toto',
                'email' => 'toto@example.com',
                'password' => 'password',
            ],
        ]);
        $response = $this->client->getResponse();

        static::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        static::assertJson($response->getContent());
        static::assertJsonMatchSchemaString($response->getContent(), self::$jsonSchemaUserRegister);
    }


    public function testUserRegisterNoPassword(): void
    {
        $this->sendPost('/users', [
            'user' => [
                'username' => 'toto',
                'email' => 'toto@example.com',
            ],
        ]);
        $response = $this->client->getResponse();

        static::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        static::assertJson($response->getContent());
    }

}
