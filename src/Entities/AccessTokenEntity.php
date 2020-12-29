<?php

declare(strict_types=1);

/*
 * This file is part of fe-openid-provider.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\FeOpenidProvider\Entities;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

class AccessTokenEntity implements AccessTokenEntityInterface
{
    use AccessTokenTrait;
    use TokenEntityTrait;
    use EntityTrait;

    protected $member;

    /**
     * Generate a string representation from the access token.
     */
    public function __toString()
    {
        return $this->convertToJWT()->toString();
    }

    public function getMember()
    {
        return $this->member;
    }

    public function setMember($member): void
    {
        $this->member = $member;
    }

    /**
     * Generate a JWT from the access token.
     *
     * @return Token
     */
    private function convertToJWT()
    {
        $this->initJwtConfiguration();

        $jwtbuilder = $this->jwtConfiguration->builder()
            ->permittedFor($this->getClient()->getIdentifier())
            ->identifiedBy($this->getIdentifier())
            ->issuedAt(new \DateTimeImmutable())
            ->canOnlyBeUsedAfter(new \DateTimeImmutable())
            ->expiresAt($this->getExpiryDateTime())
            ->relatedTo((string) $this->getUserIdentifier())
            ->withClaim('scopes', $this->getScopes())
        ;

        foreach ($GLOBALS['FEOPENID']['access_token_additional_fields_callbacks'] as $key => $callbackfunc) {
            $callbackResult = \call_user_func_array($callbackfunc, [$this->member]);

            if ('' === $key) {
                foreach ($callbackResult as $claimName => $claimValue) {
                    $jwtbuilder->withClaim($claimName, $claimValue);
                }
            } else {
                $jwtbuilder->withClaim($key, $callbackResult);
            }
        }

        return $jwtbuilder->getToken($this->jwtConfiguration->signer(), $this->jwtConfiguration->signingKey());
    }
}
