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
use League\OAuth2\Server\ResourceServer;

class ResourceServerService
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
     * @var ResourceServer Resource Server
     */
    private $service;

    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    public function getServer(): ResourceServer
    {
        if (!isset($this->service)) {
            $accessTokenRepository = new AccessTokenRepository();
            $configs = $this->getConfig()->get('feopenidprovider');
            $publicKeyPath = $configs['keypath'].'/public.key';
            $this->service = new ResourceServer(
                $accessTokenRepository,
                $publicKeyPath
            );
        }

        return $this->service;
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
