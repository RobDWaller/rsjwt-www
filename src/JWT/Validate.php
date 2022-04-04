<?php

declare(strict_types=1);

namespace RSJWT\JWT;

use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Validate as RSJValidate;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Decode;
use ReallySimpleJWT\Helper\Validator;
use ReallySimpleJWT\Encoders\EncodeHS256;
use Exception;

class Validate
{
    public function token(Jwt $token, string $secret): bool
    {
        $parse = new Parse($token, new Decode());

        $validate = new RSJValidate(
            $parse->parse(),
            new EncodeHS256($secret),
            new Validator()
        );

        try {
            $validate->signature()->expiration();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
