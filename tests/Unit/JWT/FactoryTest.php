<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\JWT\Factory;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Helper\Validator;
use ReallySimpleJWT\Encoders\EncodeHS256;

class FactoryTest extends TestCase
{
    public function testCreateToken(): void
    {
        $build = new Build('JWT', new Validator(), new EncodeHS256('!secReT$123*'));

        $factory = new Factory($build);

        $jwt = $factory->create("1", time() + 30, 'localhost');

        $this->assertInstanceOf(Jwt::class, $jwt);
    }
}
