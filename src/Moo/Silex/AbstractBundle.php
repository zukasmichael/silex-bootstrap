<?php

/*
 * This file is part of Moo\Silex package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

namespace Moo\Silex;

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\WebProfilerServiceProvider;

/**
 * AbstractBundle contains abstracted/helper methods that are needed for a bundle implementation.
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 */
abstract class AbstractBundle
{
    /**
     * An instance of Silex
     *
     * @var \Silex\Application
     */
    protected $app;

    /**
     * Bundle name
     *
     * @var string
     */
    protected $name = 'App';

    /**
     * Bootstrap
     *
     * @param  \Silex\Application        $app
     * @param  \Silex\Application        $app
     * @return \Moo\Silex\AbstractBundle
     */
    public function bootstrap(\Silex\Application $app)
    {
        $this->app = $app;

        // cache
        $this->app['cache.path'] = $this->getAppResourcesDir('cache');

        // logs
        $this->app->register(new MonologServiceProvider(), array(
            'monolog.logfile' => $this->getAppResourcesDir('logs') . '.log',
            'monolog.name'    => 'app',
            'monolog.level'   => 300 // = Logger::WARNING
        ));

        // http cache
        $this->app->register(new HttpCacheServiceProvider());
        $this->app['http_cache.cache_dir'] = $this->app['cache.path'] . '/http';

        // other services
        $this->app->register(new SessionServiceProvider());
        $this->app->register(new ValidatorServiceProvider());
        $this->app->register(new FormServiceProvider());

        // debug
        if (isset($this->app['cache.path'])) {
            $this->app->register(new ServiceControllerServiceProvider());
        }

        // twig
        $this->app->register(new TwigServiceProvider(), array(
            'twig.options'        => array(
                'cache'            => false, // $this->getAppResourcesDir('cache') . '/twig',
                'strict_variables' => true
            ),
            'twig.form.templates' => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
            'twig.path'           => array($this->getBaseDir('Resources/views'))
        ));

        // Add simple 'asset' function
        $this->app['twig'] = $this->app->share(
                $this->app->extend('twig', function(\Twig_Environment $twig, \Silex\Application $app) {
                    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($app) {
                        return $app['request']->getBasePath() . '/' . ltrim($asset, '/');
                    }));
                    return $twig;
                })
        );

        // web profiler
        $this->app->register(new WebProfilerServiceProvider(), array(
            'profiler.cache_dir'    => $this->app['cache.path'] . '/profiler',
        ));

        // setup bundle controllers
        $this->controllers();

        return $this;
    }

    /**
     * Setup bundle controllers
     *
     * @return void
     */
    protected function controllers()
    {
        
    }

    /**
     * Add a controller
     *
     * @param  string                    $controller
     * @param  string                    $class
     * @param  array                     $routes
     * @return \Moo\Silex\AbstractBundle
     */
    protected function addController($controller, $class, array $routes)
    {
        // Setup a controller
        $name = $controller . '.controller';
        $controllerClass = '\\' . $this->name . '\\Controller\\' . $class . 'Controller';
        $this->app[$name] = $this->app->share(function($app) use ($controllerClass) {
            return new $controllerClass($app);
        });

        // Setup the controller routes
        foreach ($routes as $method => $route) {
            $segments = explode('.', $method);
            $this->app->$segments[0]($route, $name . ':' . $segments[1] . 'Action')->bind($segments[1]);
        }

        return $this;
    }

    /**
     * Load bundle config parameters
     *
     * @return \Moo\Silex\AbstractBundle
     */
    protected function loadParameters()
    {
        $params = Yaml::parse(file_get_contents($this->getBaseDir('Resources/data/parameters.yml')));
        if (is_array($params)) {
            foreach ($params as $paramName => $paramValue) {
                if (!$this->app->offsetExists($paramName)) {
                    $this->app[$paramName] = $paramValue;
                }
            }
        }
        return $this;
    }

    /**
     * Get a path for an app resource
     *
     * @param  string $resource
     * @return string
     */
    protected function getAppResourcesDir($resource)
    {
        return $this->app['app_dir'] . '/' . $resource . '/' . $this->name;
    }

    /**
     * Get the bundle base dir
     *
     * @param  string $path
     * @return string
     */
    public function getBaseDir($path = '')
    {
        return __DIR__ . '/../../' . $this->name . '/' . $path;
    }

    /**
     * Run the bundle
     *
     * @param  \Silex\Application        $app
     * @return \Moo\Silex\AbstractBundle
     */
    final public function run(\Silex\Application $app)
    {
        $this->bootstrap($app);

        $this->app['http_cache']->run();

        return $this;
    }

}
