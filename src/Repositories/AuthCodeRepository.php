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
use ErikWegner\FeOpenidProvider\Entities\AuthCodeEntity;
use ErikWegner\FeOpenidProvider\Model\AuthCodeModel;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        // Some logic to persist the auth code to a database
        $authCodeModel = new AuthCodeModel();
        $authCodeModel->tstamp = time();
        $authCodeModel->code = $authCodeEntity->getIdentifier();
        $authCodeModel->expiryDateTime = $authCodeEntity->getExpiryDateTime()->getTimestamp();
        $authCodeModel->userIdentifier = $authCodeEntity->getUserIdentifier();
        $authCodeModel->client = $authCodeEntity->getClient()->getIdentifier();
        $authCodeModel->arrscopes = implode(',', array_map(
            static function ($s) {
                return $s->getIdentifier();
            },
            $authCodeEntity->getScopes()
        ));
        $authCodeModel->save();
    }

    public function revokeAuthCode($codeId): void
    {
        // Some logic to revoke the auth code in a database
        $code = AuthCodeModel::findByPk($codeId);
        $code->revoked = '1';
        $code->save();
    }

    public function isAuthCodeRevoked($codeId)
    {
        $code = AuthCodeModel::findByPk($codeId);

        return '1' === $code->revoked;
    }

    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }
    
    public static function purgeExpiredTokens() {
        $strQuery = 'DELETE FROM ' . AuthCodeModel::getTable() . ' WHERE expiryDateTime < ?';
        Database::getInstance()->prepare($strQuery)->execute(time());
    }
}
