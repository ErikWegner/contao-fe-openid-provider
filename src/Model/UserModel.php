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

use Contao\MemberModel;
use League\OAuth2\Server\Entities\UserEntityInterface;

class UserModel extends MemberModel implements UserEntityInterface
{
    public function getIdentifier()
    {
        return $this->id;
    }
}
