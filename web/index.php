<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;

ini_set('display_errors', 0);
ini_set('session.gc_maxlifetime', 8*60*60);
session_cache_expire(180);
session_start();

$app = new Application();
require __DIR__ . '/../app/config/development.php';
require __DIR__ . '/../app/dependencies.php';
require __DIR__ . '/../app/routes.php';
require __DIR__ . '/../app/middleware.php';

$app->run();
