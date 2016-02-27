<?php

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

//
//// Repository objects
//$app['VisitorRepository'] = $app->share(function ($app) {
//	return new PDOVisitorRepository($app['PDO']);
//});
//
//$app['StatsRepository'] = $app->share(function ($app) {
//	return new PDOStatsRepository($app['PDO']);
//});
//
//$app['StoreRepository'] = $app->share(function ($app) {
//	return new PDOStoreRepository($app['PDO']);
//});
//
//$app['UserRepository'] = $app->share(function () use ($app) {
//	return new PDOUserRepository($app['PDO']);
//});
//
//$app['ZoneRepository'] = $app->share(function ($app) {
//	return new PDOZoneRepository($app['PDO']);
//});
//
//$app['FloorPlanRepository'] = $app->share(function ($app) {
//	return new PDOFloorPlanRepository($app['PDO']);
//});
//
//$app['FeatureRepository'] = $app->share(function ($app) {
//	return new PDOFeatureRepository($app['PDO']);
//});
//
//// Services
//$app['UserAuthenticationService'] = $app->share(function () use ($app) {
//	return new UserAuthenticationService($app['UserRepository']);
//});
//
//$app['UserStoreAuthorisationService'] = $app->share(function () use ($app) {
//	return new UserStoreAuthorisationService($app['StoreRepository']);
//});
//
//$app['UserFeatureAuthorisationService'] = $app->share(function () use ($app) {
//	return new UserFeatureAuthorisationService($app['FeatureRepository']);
//});
//
//// Controllers
//$app['LoginController'] = $app->share(function () use ($app) {
//	return new LoginController($app['UserAuthenticationService'], $app['twig']);
//});
//
//$app['LogoutController'] = $app->share(function () use ($app) {
//	return new LogoutController($app['UserAuthenticationService'], $app['twig']);
//});
//
//$app['StatsController'] = $app->share(function () use ($app) {
//	return new StatsController(
//		$app['UserAuthenticationService'],
//		$app['UserStoreAuthorisationService'],
//		$app['StoreRepository'],
//		$app['StatsRepository'],
//		$app['twig']
//	);
//});
//
//$app['StatsController'] = $app->share(function () use ($app) {
//	return new StatsController(
//		$app['UserAuthenticationService'],
//		$app['UserStoreAuthorisationService'],
//		$app['StoreRepository'],
//		$app['StatsRepository'],
//		$app['twig']
//	);
//});
//
//$app['SideBarController'] = $app->share(function () use ($app) {
//	return new SideBarController(
//		$app['UserAuthenticationService'],
//		$app['UserFeatureAuthorisationService'],
//		$app['twig']
//	);
//});
