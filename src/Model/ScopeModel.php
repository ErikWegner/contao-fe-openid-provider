<?php

namespace ErikWegner\FeOpenidProvider\Model;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

class ScopeModel implements ScopeEntityInterface
{
    use EntityTrait, ScopeTrait;
}
