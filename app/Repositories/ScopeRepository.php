<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 17.05.19
 * Time: 15:59
 */

namespace App\Repositories;


use App\Entities\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{

    /**
     * Return information about a scope.
     *
     * @param string $identifier The scope identifier
     *
     * @return ScopeEntityInterface
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        $scope = new ScopeEntity();
        $scope->setIdentifier($identifier);

        return $scope;
    }

    /**
     * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and optionally
     * append additional scopes or remove requested scopes.
     *
     * @param ScopeEntityInterface[] $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null|string $userIdentifier
     *
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        // TODO: Implement finalizeScopes() method.
        $username = $clientEntity->getName();
        if ($username === 'admin') {
            $scope = new ScopeEntity();
            $scope->setIdentifier('caneditusers');
            $scopes[] = $scope;
        }
        return $scopes;
    }
}