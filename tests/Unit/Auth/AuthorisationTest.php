<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\Auth\Authorisation;
use RSJWT\JWT\Factory;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthorisationTest extends TestCase
{
    public function testAuthorisationSuccess(): void
    {
        $factory = new Factory();
        $token = $factory->create('1', 'pAssword123$456', time() + 30, 'localhost');

        $authorisation = new Authorisation('pAssword123$456');

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getHeader')
            ->with('authorization')
            ->willReturn(['Bearer ' . $token->getToken()]);

        $response = $this->createMock(Response::class);

        $handler = $this->createMock(RequestHandler::class);
        $handler->expects($this->once())
            ->method('handle')
            ->with($request)
            ->willReturn($response);

        $this->assertInstanceOf(Response::class, $authorisation($request, $handler));
    }

    public function testAuthorisationFailureNoToken(): void
    {
        $authorisation = new Authorisation('HelloWorld123!');

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getHeader')
            ->with('authorization')
            ->willReturn(['Bearer ']);

        $handler = $this->createMock(RequestHandler::class);

        $response = $authorisation($request, $handler);
        $this->assertSame(401, $response->getStatusCode());
        $this->assertSame('Token has an invalid structure.', json_decode($response->getBody())->message);
    }

    public function testAuthorisationFailureInvalidToken(): void
    {
        $authorisation = new Authorisation('HelloWorld123!');

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getHeader')
            ->with('authorization')
            ->willReturn(['Bearer abc.def.hij']);

        $handler = $this->createMock(RequestHandler::class);

        $response = $authorisation($request, $handler);
        $this->assertSame(401, $response->getStatusCode());
        $this->assertSame('Could not validate token.', json_decode($response->getBody())->message);
    }
}
