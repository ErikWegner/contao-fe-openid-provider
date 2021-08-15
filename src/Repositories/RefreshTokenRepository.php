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

use Contao\Database;
use ErikWegner\FeOpenidProvider\Entities\RefreshTokenEntity;
use ErikWegner\FeOpenidProvider\Model\RefreshTokenModel;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        // Some logic to persist the refresh token in a database
        $refreshTokenModel = new RefreshTokenModel();
        $refreshTokenModel->tstamp = time();
        $refreshTokenModel->token = $refreshTokenEntity->getIdentifier();
        $refreshTokenModel->expiryDateTime = $refreshTokenEntity->getExpiryDateTime()->getTimestamp();
        $refreshTokenModel->accessToken = $refreshTokenEntity->getAccessToken()->getIdentifier();
        $refreshTokenModel->save();
    }

    public function revokeRefreshToken($tokenId): void
    {
        // Some logic to revoke the refresh token in a database
        $token = RefreshTokenModel::findByPk($tokenId);
        $token->revoked = '1';
        $token->save();
    }

    public function isRefreshTokenRevoked($tokenId)
    {
        $token = RefreshTokenModel::findByPk($tokenId);

        return '1' === $token->revoked;
    }

    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }
    
    public static function purgeExpiredTokens() {
        $strQuery = 'DELETE FROM ' . RefreshTokenModel::getTable() . ' WHERE expiryDateTime < ?';
        Database::getInstance()->prepare($strQuery)->execute(time());
    }
}
