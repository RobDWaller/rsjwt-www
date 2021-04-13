<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;

class APITest extends TestCase
{
    public function testAPIToken(): void
    {
        $client = new \GuzzleHttp\Client(['port' => '8080']);
        $response = $client->request('GET', 'http://localhost/api/token');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('application/json', $response->getHeaderLine('content-type'));

        $body = json_decode($response->getBody());

        $this->assertMatchesRegularExpression(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $body->token
        );
    }
}
