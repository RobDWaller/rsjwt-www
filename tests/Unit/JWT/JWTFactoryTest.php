<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\JWT\JWTFactory;
use RSJWT\JWT\JWT;

class JWTFactoryTest extends TestCase
{
    public function testCreateToken(): void
    {
        $factory = new JWTFactory();

        $jwt = $factory->create(1, '!secReT$123*', time() + 30, 'localhost');

        $this->assertInstanceOf(JWT::class, $jwt);
    }
}
