<?php

declare(strict_types=1);

namespace RSJWT\JWT;

use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Build;

class Factory
{
    private Build $build;

    public function __construct(Build $build)
    {
        $this->build = $build;
    }

    /**
     * @param mixed $id
     */
    public function create($id, int $expiration, string $issuer): Jwt
    {
        return $this->build->setJwtId($id)
            ->setExpiration($expiration)
            ->setIssuer($issuer)
            ->build();
    }
}
