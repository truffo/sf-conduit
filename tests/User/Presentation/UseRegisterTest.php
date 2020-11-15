<?php

namespace App\Tests\User\Presentation;

use App\Tests\Common\PresentationTestCase;
use Symfony\Component\HttpFoundation\Response;

class UseRegisterTest extends PresentationTestCase
{
    public static string $jsonSchemaUserRegister = <<<'JSON'
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
JSON;

    public function testUserRegister()
    {
        $this->sendPost('/user/register', [
            'user' => [
                'username' => 'toto',
                'email' => 'toto@example.com',
                'password' => 'password'
            ]
        ]);
        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertJsonMatchSchemaString($response->getContent(), self::$jsonSchemaUserRegister);
    }

    public function testUserRegisterNoPassword()
    {
        $this->sendPost('/user/register', [
            'user' => [
                'username' => 'toto',
                'email' => 'toto@example.com'
            ]
        ]);
        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJson($response->getContent());

    }
}
