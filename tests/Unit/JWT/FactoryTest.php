<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\JWT\Factory;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Build;

class FactoryTest extends TestCase
{
    public function testCreateToken(): void
    {
        $factory = new Factory();

        $jwt = $factory->create("1", '!secReT$123*', time() + 30, 'localhost');

        $this->assertInstanceOf(Jwt::class, $jwt);
    }
}
