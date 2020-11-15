<?php

declare(strict_types=1);

namespace App\Tests\Article\Presentation;

use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ArticleGetTest extends WebTestCase
{
    use JsonAssertions;

    public function testArticleGetCodeAndFormat(): void
    {
        $client = static::createClient();
        $client->request('GET', '/articles');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        static::assertJson($response->getContent());
    }
}
