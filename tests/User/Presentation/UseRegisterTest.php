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
              "$ref": "#/definitions/NewUserRequest"
            }
          ],
          "definitions": {
            "NewUserRequest": {
              "type": "object",
              "properties": {
                "user": {
                  "$ref": "#/definitions/NewUser"
                }
              },
              "required": [
                "user"
              ]
            },
            "NewUser": {
              "type": "object",
              "properties": {
                "username": {
                  "type": "string"
                },
                "email": {
                  "type": "string"
                },
                "password": {
                  "type": "string",
                  "format": "password"
                }
              },
              "required": [
                "username",
                "email",
                "password"
              ]
            }
          }
        }
        CODE_SAMPLE;

    public function testUserRegister(): void
    {
        $this->sendPost('/user/register', [
            'user' => [
                'username' => 'toto',
                'email' => 'toto@example.com',
                'password' => 'password',
            ],
        ]);
        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        static::assertJson($response->getContent());
        $this->assertJsonMatchSchemaString($response->getContent(), self::$jsonSchemaUserRegister);
    }

    public function testUserRegisterNoPassword(): void
    {
        $this->sendPost('/user/register', [
            'user' => [
                'username' => 'toto',
                'email' => 'toto@example.com',
            ],
        ]);
        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        static::assertJson($response->getContent());
    }
}
