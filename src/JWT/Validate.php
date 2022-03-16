<?php

declare(strict_types=1);

namespace RSJWT\JWT;

use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Validate as RSJValidate;
use ReallySimpleJWT\Parse;

class Validate
{
    public function token(Jwt $token): bool
    {
        return true;
    }
}
