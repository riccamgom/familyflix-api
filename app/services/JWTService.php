<?php

namespace App\Services;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Token\Plain;

class JWTService
{
    protected $config;

    public function __construct()
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(config('jwt.secret'))
        );
        $this->config->setValidationConstraints(
            new SignedWith($this->config->signer(), $this->config->verificationKey()),
        );
    }

    public function createToken(array $claims): Plain
    {
        $now = new \DateTimeImmutable();

        return $this->config->builder()
            ->issuedBy(config('app.url'))
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+8 hours'))
            ->withClaim('uid', $claims['uid'])
            ->getToken($this->config->signer(), $this->config->signingKey());
    }

    public function parseToken(string $token)
    {
        try {
            return $this->config->parser()->parse($token);
        } catch (\Exception $e) {
            report($e);
            return null;
        }
    }

    public function validateToken(Plain $token): bool
    {
        try {
            $constraints = $this->config->validationConstraints();
            return $this->config->validator()->validate($token, ...$constraints);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }
}
