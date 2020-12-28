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

use ErikWegner\FeOpenidProvider\Model\AuthCodeModel;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        // Some logic to persist the auth code to a database
        $authCodeEntity->save();
    }

    public function revokeAuthCode($codeId): void
    {
        // Some logic to revoke the auth code in a database
        $code = AuthCodeModel::findById($codeId);
        $code->revoked = '1';
        $code->save();
    }

    public function isAuthCodeRevoked($codeId)
    {
        $code = AuthCodeModel::findById($codeId);

        return '1' === $code->revoked;
    }

    public function getNewAuthCode()
    {
        return new AuthCodeModel();
    }
}
