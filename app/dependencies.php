<?php

use Kepler\Repositories\PDO\PDOFloorPlanRepository;
use Kepler\Repositories\PDO\PDOStatsRepository;
use Kepler\Repositories\PDO\PDOStoreRepository;
use Kepler\Repositories\PDO\PDOUserRepository;
use Kepler\Repositories\PDO\PDOVisitorRepository;
use Kepler\Repositories\PDO\PDOZoneRepository;
use Kepler\Repositories\PDO\PDOFeatureRepository;

use Kepler\Services\UserAuthenticationService;
use Kepler\Services\UserStoreAuthorisationService;
use Kepler\Services\UserFeatureAuthorisationService;

use Kepler\Controllers\LoginController;
use Kepler\Controllers\LogoutController;
use Kepler\Controllers\SideBarController;
use Kepler\Controllers\Features\StatsController;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

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

// Repository objects
$app['VisitorRepository'] = $app->share(function ($app) {
	return new PDOVisitorRepository($app['PDO']);
});

$app['StatsRepository'] = $app->share(function ($app) {
	return new PDOStatsRepository($app['PDO']);
});

$app['StoreRepository'] = $app->share(function ($app) {
	return new PDOStoreRepository($app['PDO']);
});

$app['UserRepository'] = $app->share(function () use ($app) {
	return new PDOUserRepository($app['PDO']);
});

$app['ZoneRepository'] = $app->share(function ($app) {
	return new PDOZoneRepository($app['PDO']);
});

$app['FloorPlanRepository'] = $app->share(function ($app) {
	return new PDOFloorPlanRepository($app['PDO']);
});

$app['FeatureRepository'] = $app->share(function ($app) {
	return new PDOFeatureRepository($app['PDO']);
});

// Services
$app['UserAuthenticationService'] = $app->share(function () use ($app) {
	return new UserAuthenticationService($app['UserRepository']);
});

$app['UserStoreAuthorisationService'] = $app->share(function () use ($app) {
	return new UserStoreAuthorisationService($app['StoreRepository']);
});

$app['UserFeatureAuthorisationService'] = $app->share(function () use ($app) {
	return new UserFeatureAuthorisationService($app['FeatureRepository']);
});

// Controllers
$app['LoginController'] = $app->share(function () use ($app) {
	return new LoginController($app['UserAuthenticationService'], $app['twig']);
});

$app['LogoutController'] = $app->share(function () use ($app) {
	return new LogoutController($app['UserAuthenticationService'], $app['twig']);
});

$app['StatsController'] = $app->share(function () use ($app) {
	return new StatsController(
		$app['UserAuthenticationService'],
		$app['UserStoreAuthorisationService'],
		$app['StoreRepository'],
		$app['StatsRepository'],
		$app['twig']
	);
});

$app['StatsController'] = $app->share(function () use ($app) {
	return new StatsController(
		$app['UserAuthenticationService'],
		$app['UserStoreAuthorisationService'],
		$app['StoreRepository'],
		$app['StatsRepository'],
		$app['twig']
	);
});

$app['SideBarController'] = $app->share(function () use ($app) {
	return new SideBarController(
		$app['UserAuthenticationService'],
		$app['UserFeatureAuthorisationService'],
		$app['twig']
	);
});
