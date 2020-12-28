<?php

namespace ErikWegner\FeOpenidProvider\Repositories;

use ErikWegner\FeOpenidProvider\Model\ClientModel;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     *
     * @return ClientEntityInterface|null
     */
    public function getClientEntity($clientIdentifier)
    {
        return ClientModel::findOneBy('identifier', $clientIdentifier);
    }

    /**
     * Validate a client's secret.
     *
     * @param string      $clientIdentifier The client's identifier
     * @param string|null $clientSecret The client's secret (if sent)
     * @param string|null $grantType The type of grant the client is using (if sent)
     *
     * @return bool
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $client = $this->getClientEntity($clientIdentifier);
        if ($client == null) {
            return false;
        }

        if ($client->isConfidential() && $client->secret != $client) {
            return false;
        }

        return true;
    }
}
