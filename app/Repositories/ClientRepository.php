<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 17.05.19
 * Time: 15:07
 */

namespace App\Repositories;

use App\Entities\ClientEntity;
use Illuminate\Database\Capsule\Manager as Capsule;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{

    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     * @param null|string $grantType The grant type used (if sent)
     * @param null|string $clientSecret The client's secret (if sent)
     * @param bool $mustValidateSecret If true the client must attempt to validate the secret if the clientc
     *                                        is confidential
     *
     * @return ClientEntityInterface
     */
    public function getClientEntity($clientIdentifier, $grantType = null, $clientSecret = null, $mustValidateSecret = true)
    {

        $query = Capsule::table('oauth_clients')
            ->select('oauth_clients.*')
            ->where('oauth_clients.client_id', $clientIdentifier);

        $result = $query->get();
        $result = $result->toArray();


        if(count($result) === 1){
            if (password_verify($clientSecret, $result[0]->client_secret) === false)
                return;
            $client = new ClientEntity();
            $client->setIdentifier($clientIdentifier);
            $client->setName($result[0]->client_id);

            return $client;
        }

        return;
    }
}