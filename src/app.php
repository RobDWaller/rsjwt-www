<?php

namespace RSJWT;

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
            $response->getBody()->write('<a href="/hello/world">Try /hello/world</a>');
            return $response;
        });

        $this->app->get('/hello/{name}', function (Request $request, Response $response, $args) {
            $name = $args['name'];
            $response->getBody()->write("Hello, $name");
            return $response;
        });
        
        $this->app->run();
    }
}