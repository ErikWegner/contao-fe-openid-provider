<?php

namespace ErikWegner\FeOpenidProvider\Model;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

class ScopeModel implements ScopeEntityInterface {

    use EntityTrait,
        ScopeTrait;

    private $identifier;

    public function getIdentifier() {
        return $this->identifier;
    }

    public function setIdentifier($i) {
        $this->identifier = $i;
    }

}
