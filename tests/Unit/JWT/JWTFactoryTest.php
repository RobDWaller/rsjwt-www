<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\JWT\JWTFactory;
use RSJWT\JWT\JWT;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Secret;
use ReallySimpleJWT\Helper\Validator;
use ReallySimpleJWT\Encoders\EncodeHS256;

class JWTFactoryTest extends TestCase
{
    public function testCreateToken(): void
    {
        $build = new Build('JWT', new Validator(), new Secret(), new EncodeHS256());

        $factory = new JWTFactory($build);

        $jwt = $factory->create("1", '!secReT$123*', time() + 30, 'localhost');

        $this->assertInstanceOf(JWT::class, $jwt);
    }
}
