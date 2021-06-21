<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\JWT\JWT;

class JWTTest extends TestCase
{
    public function testGetToken(): void
    {
        $jwt = new JWT('abc.def.ghi', 'secret');

        $this->assertSame('abc.def.ghi', $jwt->getToken());
    }

    public function testGetSecret(): void
    {
        $jwt = new JWT('abc.def.ghi', 'secret');

        $this->assertSame('secret', $jwt->getSecret());
    }
}
