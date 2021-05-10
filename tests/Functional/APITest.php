<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;

class APITest extends TestCase
{
    private string $baseUrl;

    private string $port;

    public function setUp(): void
    {
        parent::setUp();

        $this->baseUrl = $_SERVER['TEST_URL'] ?? 'http://localhost';
        $this->port = $_SERVER['TEST_PORT'] ?? '80';
    }

    public function testAPIToken(): void
    {
        $client = new \GuzzleHttp\Client(['port' => $this->port]);
        $response = $client->request('GET', $this->baseUrl . '/api/token');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('application/json', $response->getHeaderLine('content-type'));

        $body = json_decode($response->getBody());

        $this->assertMatchesRegularExpression(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $body->token
        );
    }
}
