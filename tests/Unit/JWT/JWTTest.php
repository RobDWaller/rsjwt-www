<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\JWT\JWT;

class JWTTest extends TestCase
{
    public function testGetToken(): void
    {
        $jwt = new JWT('abc.def.ghi');

        $this->assertSame('abc.def.ghi', $jwt->getToken());
    }
}
