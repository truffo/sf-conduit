<?php

declare(strict_types=1);

namespace App\Tests\Common;

use JsonSchema\Validator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

abstract class PresentationTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @param mixed $payload
     */
    public function sendPost(string $uri, $payload): void
    {
        $this->client->request(
            Request::METHOD_POST,
            $uri,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($payload)
        );
    }

    public function assertJsonMatchSchemaString(string $jsonResponse, string $schema): void
    {
        $validator = new Validator();
        $validator->validate($jsonResponse, $schema);

        static::assertTrue($validator->isValid(), print_r($validator->getErrors(), true));
    }
}
