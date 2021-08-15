<?php

declare(strict_types=1);

/*
 * This file is part of fe-openid-provider.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\FeOpenidProvider\Service;

use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFramework;
use ErikWegner\FeOpenidProvider\Repositories\AccessTokenRepository;
use ErikWegner\FeOpenidProvider\Repositories\AuthCodeRepository;
use ErikWegner\FeOpenidProvider\Repositories\ClientRepository;
use ErikWegner\FeOpenidProvider\Repositories\RefreshTokenRepository;
use ErikWegner\FeOpenidProvider\Repositories\ScopeRepository;
use League\OAuth2\Server\AuthorizationServer as LeagueAuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;

class AuthorizationServerService
{
    /**
     * @var Config The configuration
     */
    protected $config;

    /**
     * @var ContaoFramework
     */
    private $framework;

    /**
     * Authorization server.
     *
     * @var AuthorizationServer Authorization Server
     */
    private $server;

    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    public function getServer(): LeagueAuthorizationServer
    {
        if (!isset($this->server)) {
            $clientRepository = new ClientRepository();
            $scopeRepository = new ScopeRepository();
            $accessTokenRepository = new AccessTokenRepository();
            $authCodeRepository = new AuthCodeRepository();
            $refreshTokenRepository = new RefreshTokenRepository();

            $configs = $this->getConfig()->get('feopenidprovider');
            $privateKeyPath = $configs['keypath'].'/private.key';

            $this->server = new LeagueAuthorizationServer(
                $clientRepository,
                $accessTokenRepository,
                $scopeRepository,
                $privateKeyPath,
                $configs['encryptionkey']
            );

            $authCodeGrant = new AuthCodeGrant(
                $authCodeRepository,
                $refreshTokenRepository,
                new \DateInterval('PT10M') // access tokens will expire after 10 minutes
            );
            $authCodeGrant->disableRequireCodeChallengeForPublicClients();
            $this->server->enableGrantType(
                $authCodeGrant,
                new \DateInterval('PT10M') // access tokens will expire after 10 minutes
            );
            $this->server->enableGrantType(
                new ClientCredentialsGrant(),
                new \DateInterval('PT10M') // access tokens will expire after 10 minutes
            );
            $this->server->enableGrantType(
                new RefreshTokenGrant($refreshTokenRepository),
                new \DateInterval('PT10M') // access tokens will expire after 10 minutes
            );
        }

        return $this->server;
    }

    /**
     * Gets the configuration.
     *
     * @return Config The Configuration
     */
    protected function getConfig()
    {
        if (!isset($this->config)) {
            $this->framework->initialize();
            $this->config = $this->framework->getAdapter(Config::class);
        }

        return $this->config;
    }
}
