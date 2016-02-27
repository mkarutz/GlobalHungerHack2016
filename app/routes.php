<?php

use Silex\Application;

/** @var Application $app */

// Landing page
$app->get('/', 'LandingController:dispatch');

// Sign up
$app->get('/signup', 'UsersController:signup');
$app->post('/signup', 'UsersController:create');

// Log in
$app->get('/login', 'UsersController:login');
$app->post('/login', 'UsersController:auth');

// Log out
$app->get('/logout', 'UsersController:logout');

// Home page
$app->get('/app', 'AppController:home');

//// Browse feeds
//$app->get('/feeds', 'FeedsController:index');

// View a feed
$app->get('/feeds/{feedId}', 'FeedsController:view');

//// Send a request for an invitation
//$app->post('/feeds/{feedId}/requests/new', 'RequestsController:create');
//
//// View invitations
//$app->get('/invitations', 'InvitationsController:index');
//
//// View invitation and navigate to Feed
//$app->get('/invitations/{invitationId}', 'InvitationsController:view');

// Create a feed
$app->get('/feeds/new', 'FeedsController:form');
$app->post('/feeds/new', 'FeedsController:create');

//// View requests
//$app->get('/requests', 'RequestsController:index');
//
//// View request details
//$app->get('/requests/{requestId}', 'RequestsController:view');
//
//// Accept the request: create a new invitation
//$app->post('/feeds/{feedId}/requests/{requestId}/accept', 'InvitationsController:send');
