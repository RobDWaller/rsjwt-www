<?php

declare(strict_types=1);

namespace RSJWT\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReallySimpleJWT\Jwt;
use RSJWT\JWT\Validate;
use Slim\Psr7\Response;
use Exception;

class Authorisation
{
    private $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        try {
            $jwt = new Jwt($this->getToken($request));
            $validate = new Validate();
            if ($validate->token($jwt, $this->secret)) {
                return $handler->handle($request);
            }
        } catch (Exception $e) {
            $response = new Response();
            $response = $response->withStatus(401);
            $response->getBody()->write((string) json_encode([
                'code' => 401,
                'message' => $e->getMessage(),
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        }

        $response = new Response();
        $response = $response->withStatus(401);
        $response->getBody()->write((string) json_encode([
            'code' => 401,
            'message' => 'Could not validate token.',
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function getToken(Request $request): string
    {
        $authorization = $request->getHeader('authorization');

        $bearer = array_filter($authorization, function ($item) {
            return (bool) preg_match('/^Bearer\s.+/', $item);
        });

        $token = explode(' ', $bearer[0] ?? '')[1] ?? '';

        return !empty($token) ? $token : '';
    }
}
