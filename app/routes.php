<?php

use Silex\Application;

/** @var Application $app */

$app->get('/', 'LandingController:dispatch');

$app->get('/signup', 'SignUpController:get');
$app->post('/signup', 'SignUpController:post');

$app->get('/login', 'LoginController:get');
$app->post('/login', 'LoginController:post');

$app->get('/logout', 'LogoutController:logout');

// Browse feeds
$app->get('/feeds', 'FeedsController:index');

// View a feed
$app->get('/feeds/{feedId}', 'FeedsController:view');

// Create a feed
$app->get('/feeds/new', 'FeedsController:new');
$app->post('/feeds/new', 'FeedsController:create');

$app->get('/feeds/new', 'FeedsController:new');