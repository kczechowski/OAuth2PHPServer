<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 17.05.19
 * Time: 15:20
 */

namespace App\Repositories;


use App\Entities\AccessTokenEntity;
use Illuminate\Database\Capsule\Manager as Capsule;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{

    /**
     * Create a new access token
     *
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed $userIdentifier
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);
        return $accessToken;
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $token = $accessTokenEntity->getIdentifier();
        $client_id = $accessTokenEntity->getClient()->getIdentifier();
        $expiresAt = $accessTokenEntity->getExpiryDateTime();
        $scopes = $accessTokenEntity->getScopes();
        foreach ($scopes as $scope){
            $scopeArr[] = $scope->getIdentifier();
        }
        $scopeStr = isset($scopeArr) ? implode(' ', $scopeArr) : null;
        Capsule::table('oauth_access_tokens')
            ->insert([
                'access_token' => $token,
                'client_id' => $client_id,
                'expires_at' => $expiresAt,
                'scope' => $scopeStr,
                'is_revoked' => false
            ]);
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        // TODO: Implement revokeAccessToken() method.
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        // TODO: Implement isAccessTokenRevoked() method.
        return false;
    }
}