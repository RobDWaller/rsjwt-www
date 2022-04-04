<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use Exception;

class APITest extends TestCase
{
    private string $baseUrl;

    private string $port;

    public function setUp(): void
    {
        parent::setUp();

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();

        $this->baseUrl = $_SERVER['TEST_URL'] ?? 'http://localhost';
        $this->port = $_SERVER['TEST_PORT'] ?? '80';
    }

    public function testGetToken(): object
    {
        $client = new \GuzzleHttp\Client(['port' => $this->port]);
        $response = $client->request('POST', $this->baseUrl . '/api/token');

        $this->assertSame(201, $response->getStatusCode());
        $this->assertStringContainsString('application/json', $response->getHeaderLine('content-type'));

        $body = json_decode($response->getBody());

        $this->assertMatchesRegularExpression(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $body->token
        );

        return $body;
    }

    /**
     * @depends testGetToken
     */
    public function testGetAutomata(object $body): void
    {
        $client = new \GuzzleHttp\Client(['port' => $this->port]);
        $response = $client->request(
            'GET',
            $this->baseUrl . '/api/automata',
            ['headers' => ['authorization' => 'Bearer ' . $body->token]]
        );

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('application/json', $response->getHeaderLine('content-type'));

        $body = json_decode($response->getBody());

        $this->assertCount(5, $body->automata);
    }

    public function testGetAutomataFailInvalidToken(): void
    {
        $client = new \GuzzleHttp\Client(['port' => $this->port]);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Could not validate token.');
        $client->request(
            'GET',
            $this->baseUrl . '/api/automata',
            ['headers' => ['authorization' => 'Bearer abc.def.ghi']]
        );
    }

    public function testGetAutomataFailNoToken(): void
    {
        $client = new \GuzzleHttp\Client(['port' => $this->port]);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Token has an invalid structure.');
        $client->request('GET', $this->baseUrl . '/api/automata');
    }
}
