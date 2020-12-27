<?php

namespace ErikWegner\FeOpenidProvider\Repositories;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use OAuth2ServerExamples\Entities\RefreshTokenEntity;
use ErikWegner\FeOpenidProvider\Model\RefreshTokenModel;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface {

    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity) {
        // Some logic to persist the refresh token in a database
        $refreshTokenEntity->save();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId) {
        // Some logic to revoke the refresh token in a database
        $token = RefreshTokenModel::findById($tokenId);
        $token->revoked = '1';
        $token->save();
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId) {
        $token = RefreshTokenModel::findById($tokenId);
        return $token->revoked === '1';
    }

    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken() {
        return new RefreshTokenModel();
    }

}
