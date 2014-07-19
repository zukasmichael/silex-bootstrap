<?php

/*
 * App main bootstrap file
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

// Set timezone
date_default_timezone_set(@date_default_timezone_get());

// composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

//+----------- setup app basic settings -----------+//

use Symfony\Component\HttpKernel\Exception;

$app = new \Silex\Application();
$app['debug'] = defined('DEBUG')? DEBUG : false;
$app['app_dir'] = __DIR__;

$app->register(new \Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }
    $code = ($e instanceof Exception\HttpException) ? $e->getStatusCode() : 500;

    return $app['twig']->render('error.html.twig', array('code' => $code, 'e' => $e));
});

return $app;
