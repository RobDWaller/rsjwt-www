<?php

namespace Tests\Unit\JWT;

use PHPUnit\Framework\TestCase;
use RSJWT\JWT\Validate;
use ReallySimpleJWT\Validate as RSJValidate;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Encoders\EncodeHS256;
use ReallySimpleJWT\Helper\Validator;

class ValidateTest extends TestCase
{
    public function testValidateToken(): void
    {
        $build = new Build('JWT', new Validator(), new EncodeHS256('!secReT$123*'));

        $token = $build->setJwtId("1")
            ->setExpiration(time() + 20)
            ->setIssuer('localhost')
            ->build();

        $validate = new Validate();

        $this->assertTrue($validate->token($token, '!secReT$123*'));
    }

    public function testValidateTokenFail(): void
    {
        $build = new Build('JWT', new Validator(), new EncodeHS256('!secReT$123*'));

        $token = $build->setJwtId("1")
            ->setPayloadClaim("exp", time() - 20)
            ->setIssuer('localhost')
            ->build();

        $validate = new Validate();

        $this->assertFalse($validate->token($token, '!secReT$123*'));
    }
}
