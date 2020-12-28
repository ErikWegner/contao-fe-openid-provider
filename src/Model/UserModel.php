<?php

namespace ErikWegner\FeOpenidProvider\Model;

use Contao\MemberModel;
use League\OAuth2\Server\Entities\UserEntityInterface;

class UserModel extends MemberModel implements UserEntityInterface {
    
    public function getIdentifier() {
        return $this->id;
    }

}
