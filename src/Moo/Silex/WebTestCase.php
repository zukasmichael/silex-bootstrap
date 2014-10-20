<?php

/*
 * This file is part of Moo\Silex package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

namespace Moo\Silex;

use Silex\WebTestCase as BaseWebTestCase;

/**
 * WebTestCase contains abstracted/helper methods that are needed for a bundle implementation.
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 */
abstract class WebTestCase extends BaseWebTestCase
{
    /**
     * An instance of bundle
     *
     * @var \Moo\Silex\Bundle
     */
    protected $bundle;

    /**
     * Get bundle class
     *
     * @return \Moo\Silex\Bundle
     */
    protected function getBundle()
    {
        if (null === $this->bundle) {
            $this->bundle = $this->createBundle();
        }

        return $this->bundle;
    }

    /**
     * Returns an instance of a bundle
     *
     * @return \Moo\Silex\Bundle
     */
    abstract protected function createBundle();

    /**
     * Creates the application.
     *
     * @return \Silex\Application
     */
    public function createApplication()
    {
        $app = require $this->getApplicationDir() . '/bootstrap.php';
        $app['debug'] = true;
        $this->getBundle()->bootstrap($app);

        return $app;
    }

    /**
     * Returns the application dir
     *
     * @return string
     */
    public function getApplicationDir()
    {
        return __DIR__ . '/../../../app';
    }

}
