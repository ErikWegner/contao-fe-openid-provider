<?php

declare(strict_types=1);

/*
 * This file is part of fe-openid-provider.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\FeOpenidProvider\Repositories;

use ErikWegner\FeOpenidProvider\Entities\AccessTokenEntity;
use ErikWegner\FeOpenidProvider\Model\AccessTokenModel;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        // Some logic here to save the access token to a database
        $accessTokenModel = new AccessTokenModel();
        $accessTokenModel->code = $accessTokenEntity->getIdentifier();
        $accessTokenModel->expiryDateTime = $accessTokenEntity->getExpiryDateTime()->getTimestamp();
        $accessTokenModel->userIdentifier = $accessTokenEntity->getUserIdentifier();
        $accessTokenModel->client = $accessTokenEntity->getClient()->getIdentifier();
        $accessTokenModel->arrscopes = implode(',', array_map(
            static function ($s) {
                return $s->getIdentifier();
            },
            $accessTokenEntity->getScopes()
        ));
        $accessTokenModel->save();
    }

    public function revokeAccessToken($tokenId): void
    {
        // Some logic here to revoke the access token
        $token = AccessTokenModel::findByPk($tokenId);
        $token->revoked = '1';
        $token->save();
    }

    public function isAccessTokenRevoked($tokenId)
    {
        $token = AccessTokenModel::findByPk($tokenId);

        return '1' === $token->revoked;
    }

    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);

        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }
}
