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
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

class AuthCodeModel extends Model implements AuthCodeEntityInterface
{
    use EntityTrait;
    use TokenEntityTrait;
    use AuthCodeTrait;

    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_feopenid_accesstoken';
}
