<?php

namespace RSJWT;

use ReallySimpleJWT\Token;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App as SlimApp;

class App
{
    private SlimApp $app;

    public function __construct(SlimApp $app)
    {
        $this->app = $app;
    }

    public function run(): void
    {
        $this->app->addErrorMiddleware(true, true, true);

        $this->app->get('/', function (Request $request, Response $response) {
            $response->getBody()->write('<a href="/api/token">Try /api/token</a>');
            return $response;
        });

        $this->app->get('/api/token', function (Request $request, Response $response) {
            $token = Token::create(1, '!secReT$123*', time() + 30, $_SERVER['HTTP_HOST']);
            $response->getBody()->write((string) json_encode(['token' => $token]));
            return $response->withHeader('Content-Type', 'application/json');
        });

        $this->app->run();
    }
}
