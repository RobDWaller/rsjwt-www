<?php

declare(strict_types=1);

namespace RSJWT\JWT;

use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Helper\Validator;
use ReallySimpleJWT\Encoders\EncodeHS256;

class Factory
{
    /**
     * @param mixed $id
     */
    public function create($id, string $secret, int $expiration, string $issuer): Jwt
    {
        $build = new Build('JWT', new Validator(), new EncodeHS256($secret));
        return $build->setJwtId($id)
            ->setExpiration($expiration)
            ->setIssuer($issuer)
            ->build();
    }
}
