<?php

declare(strict_types=1);

namespace RSJWT\JWT;

use RSJWT\JWT\JWT;
use ReallySimpleJWT\Build;

class JWTFactory
{
    private Build $build;

    public function __construct(Build $build)
    {
        $this->build = $build;
    }

    /**
     * @param mixed $id
     */
    public function create($id, int $expiration, string $issuer): JWT
    {
        $jwt = $this->build->setJwtId($id)
            ->setExpiration($expiration)
            ->setIssuer($issuer)
            ->build();

        return new JWT($jwt->getToken());
    }
}
