<?php

namespace App\Tests\Article\Presentation;

use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleGetTest extends WebTestCase
{
    use JsonAssertions;

    public function testArticleGetCodeAndFormat()
    {
        $client = static::createClient();
        $client->request('GET', '/articles');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
    }
}
