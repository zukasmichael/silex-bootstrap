<?php

/*
 * This file is part of MyApp\Tests package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

namespace MyApp\Tests;

/**
 * PageFoundTest is the availability of the site pages.
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 */
class PageFoundTest extends \Moo\Silex\WebTestCase
{

    public function testHomepage()
    {
        $client = $this->createClient();
        $client->request('GET', '/test');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('MyApp Example', $client->getResponse()->getContent());
        $this->assertContains('test', $client->getResponse()->getContent());
    }

    protected function createBundle()
    {
        return new \MyApp\MyAppBundle;
    }

}
