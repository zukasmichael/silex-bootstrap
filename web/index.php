<?php

$app = require_once __DIR__ . '/../app/bootstrap.php';

$bundle = new \MyApp\MyAppBundle;
$bundle->run($app);
