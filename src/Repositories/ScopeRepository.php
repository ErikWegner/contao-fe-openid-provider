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

use ErikWegner\FeOpenidProvider\Model\ScopeModel;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($scopeIdentifier)
    {
        $scopes = [
            'openid' => [
                'description' => 'Basic login',
            ],
            'basic' => [
                'description' => 'Basic details about you',
            ],
            'email' => [
                'description' => 'Your email address',
            ],
        ];

        if (false === \array_key_exists($scopeIdentifier, $scopes)) {
            return;
        }

        $scope = new ScopeModel();
        $scope->setIdentifier($scopeIdentifier);

        return $scope;
    }

    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        // Example of programatically modifying the final scope of the access token
        if (1 === (int) $userIdentifier) {
            $scope = new ScopeModel();
            $scope->setIdentifier('email');
            $scopes[] = $scope;
        }

        return $scopes;
    }
}
