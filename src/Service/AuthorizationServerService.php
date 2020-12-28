<?php

namespace ErikWegner\FeOpenidProvider\Service;

use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFramework;
use ErikWegner\FeOpenidProvider\Repositories\ClientRepository;
use ErikWegner\FeOpenidProvider\Repositories\ScopeRepository;
use ErikWegner\FeOpenidProvider\Repositories\AccessTokenRepository;
use ErikWegner\FeOpenidProvider\Repositories\AuthCodeRepository;
use ErikWegner\FeOpenidProvider\Repositories\RefreshTokenRepository;
use League\OAuth2\Server\AuthorizationServer as LeagueAuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\AuthCodeGrant;

class AuthorizationServerService
{
    /**
     * @var ContaoFramework
     */
    private $framework;

    /**
     * Authorization server
     * @var League\OAuth2\Server\AuthorizationServer Authorization Server
     */
    private $server;


    /**
     * @var Config The configuration
     */
    protected $config;

    /**
     * Gets the configuration.
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

    function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }


    function getServer(): LeagueAuthorizationServer
    {
        if (!isset($this->server)) {
            $clientRepository = new ClientRepository();
            $scopeRepository = new ScopeRepository();
            $accessTokenRepository = new AccessTokenRepository();
            $authCodeRepository = new AuthCodeRepository();
            $refreshTokenRepository = new RefreshTokenRepository();

            $configs = $this->getConfig()->get('feopenidprovider');
            $privateKeyPath = $configs['keypath'] . '/private.key';

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
                new \DateInterval('PT10M')
            );
            $authCodeGrant->disableRequireCodeChallengeForPublicClients();
            $this->server->enableGrantType(
                $authCodeGrant,
                new \DateInterval('PT1H')
            );
        }

        return $this->server;
    }
}
