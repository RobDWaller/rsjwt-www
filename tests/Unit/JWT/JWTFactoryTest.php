<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\JWT\JWTFactory;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Helper\Validator;
use ReallySimpleJWT\Encoders\EncodeHS256;

class JWTFactoryTest extends TestCase
{
    public function testCreateToken(): void
    {
        $build = new Build('JWT', new Validator(), new EncodeHS256('!secReT$123*'));

        $factory = new JWTFactory($build);

        $jwt = $factory->create("1", time() + 30, 'localhost');

        $this->assertInstanceOf(Jwt::class, $jwt);
    }
}
