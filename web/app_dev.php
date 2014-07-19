<?php

// Enable debugging
define('DEBUG', true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

$app = require_once __DIR__ . '/../app/bootstrap.php';
$app['debug'] = true;

$bundle = new \MyApp\MyAppBundle;
$bundle->run($app);
