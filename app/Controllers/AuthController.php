<?php
/**
 * Created by PhpStorm.
 * User: kczechowski
 * Date: 11.05.19
 * Time: 01:02
 */

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as Capsule;
use League\OAuth2\Server\Exception\OAuthServerException;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{
    public function getAccessToken(Request $request, Response $response)
    {
        /* @var \League\OAuth2\Server\AuthorizationServer $server */
        $server = $this->container['authServer'];

        try {
            // Try to respond to the request
            return $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {
            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            $body = $response->getBody();
            $body->write($exception->getMessage());
            return $response->withStatus(500)->withBody($body);
        }
    }

    public function verifyAccessToken(Request $request, Response $response)
    {
        /* @var \League\OAuth2\Server\ResourceServer $server */
        $server = $this->container['resourceServer'];

        try {
            return $server->validateAuthenticatedRequest($request);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            $body = $response->getBody();
            $body->write($exception->getMessage());
            return $response->withStatus(500)->withBody($body);
        }
    }

    public function registerUser(Request $request, Response $response)
    {
        $params = $request->getParams();
        //validate

        Capsule::table('oauth_clients')
            ->insert([
                'client_id' => $params['username'],
                'client_secret' => $params['password'],
                'email' => $params['email']
            ]);

        return $response->withStatus(201, 'user created');
    }

    public function getUserInfo(Request $request, Response $response)
    {
        $user = $request->getAttribute('oauth_client_id');

        $query = Capsule::table('oauth_clients')
            ->select('oauth_clients.client_id', 'oauth_clients.email')
            ->where('oauth_clients.client_id', $user);

        $result = $query->get();
        $result = $result->toArray();

        return $response->withJson($result[0]);
    }
}