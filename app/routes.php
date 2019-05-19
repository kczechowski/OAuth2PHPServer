<?php

$app->get('/', '\App\Controllers\HomeController:index');
$app->post('/token', '\App\Controllers\AuthController:getAccessToken');
$app->post('/token/verify', '\App\Controllers\AuthController:verifyAccessToken');
$app->get('/login', '\App\Controllers\LoginFormController:loginForm');
$app->get('/register', '\App\Controllers\RegisterFormController:registerForm');
$app->post('/user', '\App\Controllers\AuthController:registerUser');
$app->get('/user', '\App\Controllers\AuthController:getUserInfo')->add(new \League\OAuth2\Server\Middleware\ResourceServerMiddleware($app->getContainer()['resourceServer']));