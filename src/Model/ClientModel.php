<?php

namespace ErikWegner\FeOpenidProvider\Model;

use Contao\Model;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

class ClientModel extends Model implements ClientEntityInterface {

    use EntityTrait,
        ClientTrait;

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_feopenid_client';

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri() {
        return $this->getRelated('tl_feopenid_redirecturi');
    }

}
