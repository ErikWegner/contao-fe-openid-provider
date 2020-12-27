<?php

namespace ErikWegner\FeOpenidProvider\Model;

use Contao\Model;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

class RefreshTokenModel extends Model implements RefreshTokenEntityInterface {

    use RefreshTokenTrait,
        EntityTrait;

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_feopenid_accesstoken';

}
