<?php

use Kepler\Services\UserAuthenticationService;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/** @var Application $app */

// Redirect not logged in to /login
$app->before(function (Request $request, Application $app) {
	/** @var UserAuthenticationService $userAuthenticationService */
	$userAuthenticationService = $app['UserAuthenticationService'];
	if ($request->getPathInfo() != '/login' && !$userAuthenticationService->isLoggedIn()) {
		return new RedirectResponse('/login');
	}
});

//
//// UserAppAuthorisationService
//$app->before(function (Request $request, Application $app) {
//	/** @var UserAuthenticationService $userAuthenticationService */
//	$userAuthenticationService = $app[UserAuthenticationService::class];
//	/** @var UserFeatureAuthorisationService $userFeatureAuthorisationService */
//	$userFeatureAuthorisationService = $app[UserFeatureAuthorisationService::class];
//	$user = $userAuthenticationService->getUser();
//	if (!$userFeatureAuthorisationService->isAuthorised($user, $request->getPathInfo())) {
//		return new RedirectResponse('/');
//	}
//});
