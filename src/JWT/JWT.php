<?php

declare(strict_types=1);

namespace RSJWT\JWT;

class JWT
{
    private string $token;

    private string $secret;

    public function __construct(string $token, string $secret)
    {
        $this->token = $token;

        $this->secret = $secret;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}
