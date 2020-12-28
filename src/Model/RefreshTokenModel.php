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
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

class RefreshTokenModel extends Model implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait;
    use EntityTrait;

    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_feopenid_refreshtoken';

    /**
     * Primary key
     * @var string
     */
    protected static $strPk = 'token';
}
