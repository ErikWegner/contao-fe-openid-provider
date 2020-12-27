<?php

namespace ErikWegner\FeOpenidProvider\Model;

use Contao\Model;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

class AccessTokenModel extends Model implements AccessTokenEntityInterface {

    use AccessTokenTrait,
        TokenEntityTrait,
        EntityTrait;

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_feopenid_accesstoken';

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope) {
        $a = $this->getScopes();
        $a[] = $scope;
        $this->arrscopes = implode(',', array_map(function($s) {
                return $s->getIdentifier();
            }, $a));
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return ScopeEntityInterface[]
     */
    public function getScopes() {
        $v = explode(',', $this->arrscopes);
        return array_map(function($s) {
            $t = new ScopeModel();
            $t->setIdentifier($s);
            return $t;
        }, $v);
    }

}
