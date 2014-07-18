<?php

/*
 * This file is part of Moo\Silex package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

namespace Moo\Silex;

/**
 * AbstractController contains abstracted/helper methods for bundle controllers.
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 */
abstract class AbstractController
{
    /**
     * An instance of Silex
     *
     * @var \Silex\Application
     */
    protected $app;

    /**
     * Constructor
     *
     * @param \Silex\Application $app
     */
    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }

    /**
     * Render a view
     *
     * @param  string                                     $name
     * @param  array                                      $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function render($name, $data = null)
    {
        return $this->app['twig']->render($name . '.html.twig', $data);
    }

}
