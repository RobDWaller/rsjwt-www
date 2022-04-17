<?php

namespace RSJWT;

use RSJWT\Auth\Authorisation;
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
            $response->getBody()->write('<form method="post" action="/api/token">' .
                '<input type="submit" value="Try api/token"/>' .
            '</form>');
            return $response;
        });

        $this->app->post('/api/token', function (Request $request, Response $response) {
            $factory = $this->get('jwtFactory');
            $jwt = $factory->create("1", '', time() + 30, $_SERVER['HTTP_HOST']);
            $response->getBody()->write((string) json_encode(['token' => $jwt->getToken()]));
            $response = $response->withStatus(201);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $this->app->get('/api/automata', function (Request $request, Response $response) {
            $automata = $this->get('automata');

            $response->getBody()->write((string) json_encode([
                'automata' => $automata->generate(110, 4, '01010')->toArray()
            ]));
            $response = $response->withStatus(200);
            return $response->withHeader('Content-Type', 'application/json');
        })->add(new Authorisation(''));

        $this->app->run();
    }
}
