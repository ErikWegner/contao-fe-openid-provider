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
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;

class ClientModel extends Model implements ClientEntityInterface
{
    use ClientTrait;

    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_feopenid_client';

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|array<string>
     */
    public function getRedirectUri()
    {
        $relatedUriModels = RedirectUriModel::findBy('pid', $this->id);
        $uris = [];

        if ($relatedUriModels) {
            foreach ($relatedUriModels as $relatedUriModel) {
                $uris[] = $relatedUriModel->uri;
            }
        }

        return $uris;
    }

    public function isConfidential()
    {
        return $this->confidential;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getName()
    {
        return $this->name;
    }
}
