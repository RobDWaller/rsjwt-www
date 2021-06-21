<?php

declare(strict_types=1);

namespace RSJWT\JWT;

use RSJWT\JWT\JWT;
use ReallySimpleJWT\Token;

class JWTFactory
{
    /**
     * @param mixed $id
     */
    public function create($id, string $secret, int $expiration, string $issuer): JWT
    {
        $token = Token::create($id, $secret, $expiration, $issuer);
        return new JWT($token, $secret);
    }
}
