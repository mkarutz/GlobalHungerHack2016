<?php

use FedUp\Controllers\AppController;
use FedUp\Controllers\FeedsController;
use Silex\Application;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

use FedUp\DAOs\UserDAO;

use FedUp\Controllers\LandingController;
use FedUp\Controllers\UsersController;

/** @var Application $app */

// Service Providers
$app->register(new HttpFragmentServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider(), array(
	'twig.path' => $app['twig.path'],
	'twig.options' => $app['twig.options']
));

// PDO
$app['PDO'] = $app->share(function ($app) {
	return new PDO($app['db.dsn'], $app['db.username'], $app['db.password']);
});

// DAOs
$app['UserDAO'] = $app->share(function () use ($app) {
	return new UserDAO($app['PDO']);
});

$app['FeedDAO'] = $app->share(function () use ($app) {
	return new \FedUp\DAOs\FeedDAO($app['PDO']);
});

$app['SuburbDAO'] = $app->share(function () use ($app) {
	return new \FedUp\DAOs\SuburbDAO($app['PDO']);
});

$app['AddressDAO'] = $app->share(function () use ($app) {
	return new \FedUp\DAOs\AddressDAO($app['PDO']);
});

$app['InvitationDAO'] = $app->share(function () use ($app) {
	return new \FedUp\DAOs\InvitationDAO($app['PDO']);
});

$app['RequestDAO'] = $app->share(function () use ($app) {
	return new \FedUp\DAOs\RequestDAO($app['PDO']);
});


// Services
$app['UserAuthenticationService'] = $app->share(function () use ($app) {
	return new \FedUp\Services\UserAuthenticationService($app['UserDAO']);
});

// Controllers
$app['LandingController'] = $app->share(function () use ($app) {
	return new LandingController($app['twig']);
});

$app['UsersController'] = $app->share(function () use ($app) {
	return new UsersController($app['UserAuthenticationService'], $app['UserDAO'], $app['twig']);
});

$app['AppController'] = $app->share(function () use ($app) {
	return new AppController($app['twig']);
});

$app['FeedsController'] = $app->share(function () use ($app) {
	return new FeedsController(
		$app['UserAuthenticationService'],
		$app['FeedDAO'],
		$app['AddressDAO'],
		$app['SuburbDAO'],
		$app['UserDAO'],
		$app['twig']
	);
});
