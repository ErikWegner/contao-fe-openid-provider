<?php

namespace ErikWegner\FeOpenidProvider\Repositories;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use ErikWegner\FeOpenidProvider\Entities\RefreshTokenEntity;
use ErikWegner\FeOpenidProvider\Model\RefreshTokenModel;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        // Some logic to persist the refresh token in a database
        $refreshTokenModel = new RefreshTokenModel();
        $refreshTokenModel->token = $refreshTokenEntity->getIdentifier();
        $refreshTokenModel->expiryDateTime = $refreshTokenEntity->getExpiryDateTime()->getTimestamp();
        $refreshTokenModel->accessToken = $refreshTokenEntity->getAccessToken()->getIdentifier();
        $refreshTokenModel->save();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId)
    {
        // Some logic to revoke the refresh token in a database
        $token = RefreshTokenModel::findByPk($tokenId);
        $token->revoked = '1';
        $token->save();
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $token = RefreshTokenModel::findByPk($tokenId);
        return $token->revoked === '1';
    }

    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }
}
