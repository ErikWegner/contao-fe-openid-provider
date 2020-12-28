<?php

declare(strict_types=1);

/*
 * This file is part of fe-openid-provider.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\FeOpenidProvider\Model;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

class ScopeModel implements ScopeEntityInterface
{
    use EntityTrait;
    use ScopeTrait;

    private $identifier;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($i): void
    {
        $this->identifier = $i;
    }
}
