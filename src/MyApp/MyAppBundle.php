<?php

/*
 * This file is part of Moo\Silex package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

namespace MyApp;

/**
 * MyAppBundle is the bundle main class.
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 */
class MyAppBundle extends \Moo\Silex\AbstractBundle
{
    protected $name = 'MyApp';

    public function bootstrap(\Silex\Application $app)
    {
        parent::bootstrap($app);

        // bundle parameters
        $this->loadParameters();

        // add global variable (twig)
        $detect = new \Mobile_Detect();
        $app["twig"]->addGlobal("ismobile", $detect->isMobile());

        // register Swift mailer
        $app->register(new \Silex\Provider\SwiftmailerServiceProvider());
    }

    protected function controllers()
    {
        $this->addController('index', 'Index', array(
            'get.contact' => '/contact',
            'post.contact' => '/contact',
            'get.index' => '/{name}',
        ));
    }

}
