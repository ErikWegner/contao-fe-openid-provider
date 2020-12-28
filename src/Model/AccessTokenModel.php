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

use Contao\Model;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

class AccessTokenModel extends Model implements AccessTokenEntityInterface
{
    use AccessTokenTrait;
    use TokenEntityTrait;
    use EntityTrait;

    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_feopenid_accesstoken';

    /**
     * Associate a scope with the token.
     */
    public function addScope(ScopeEntityInterface $scope): void
    {
        $a = $this->getScopes();
        $a[] = $scope;
        $this->arrscopes = implode(',', array_map(
            static function ($s) {
                return $s->getIdentifier();
            },
            $a
        ));
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return array<ScopeEntityInterface>
     */
    public function getScopes()
    {
        $v = explode(',', $this->arrscopes);

        return array_map(
            static function ($s) {
                $t = new ScopeModel();
                $t->setIdentifier($s);

                return $t;
            },
            $v
        );
    }
}
