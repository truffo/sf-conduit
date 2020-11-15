<?php

namespace App\Tests\Common;

use App\Shared\Application\CQRS\CommandBus;
use App\Shared\Application\CQRS\QueryBus;
use JsonSchema\Validator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class PresentationTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @param mixed $payload
     */
    public function sendPost(string $uri, $payload)
    {
        $this->client->request(
            Request::METHOD_POST,
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );
    }

    public function assertJsonMatchSchemaString(string $jsonResponse, string $schema)
    {
        $validator = new Validator();
        $validator->validate($jsonResponse, json_decode($schema));

        $this->assertTrue($validator->isValid(), print_r($validator->getErrors(), true));
    }
}
