<?php

ob_end_clean();

use App\Repositories\AccessTokenRepository;
use App\Repositories\ClientRepository;
use App\Repositories\ScopeRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\ResourceServer;

define('ROOT_PATH', __DIR__ . '/../');
define('VENDOR_PATH', __DIR__ . '/../vendor/');
define('APP_PATH', __DIR__ . '/../app/');
define('PUBLIC_PATH', __DIR__ . '/../public/');

require VENDOR_PATH . 'autoload.php';

$dotenv = \Dotenv\Dotenv::create(ROOT_PATH);
$dotenv->load();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => $_ENV['DB_DRIVER'],
            'database' => ROOT_PATH . $_ENV['DB_DBNAME'],
            'charset' => $_ENV['DB_CHARSET'],
            'collation' => $_ENV['DB_COLLATION'],
        ]
    ]
]);

$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Content-Type"],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));

$clientRepository = new ClientRepository();
$scopeRepository = new ScopeRepository();
$accessTokenRepository = new AccessTokenRepository();
$privateKey = 'file://' . ROOT_PATH . 'private.key';
$publicKey = 'file://' . ROOT_PATH . 'public.key';

$authServer = new AuthorizationServer(
    $clientRepository,
    $accessTokenRepository,
    $scopeRepository,
    $privateKey,
    $publicKey
);

$authServer->enableGrantType(
    new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
    new DateInterval('PT1H') // access tokens will expire after 1 hour
);

$resourceServer = new ResourceServer(
    $accessTokenRepository,
    $publicKey
);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['authServer'] = $authServer;
$container['resourceServer'] = $resourceServer;

require APP_PATH . 'routes.php';