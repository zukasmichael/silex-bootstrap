<?php

/*
 * This file is part of MyApp\Tests package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

namespace MyApp\Tests;

/**
 * PageNotFoundTest is the non-availability of the site pages.
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 */
class PageNotFoundTest extends \Moo\Silex\WebTestCase
{

    public function test404()
    {
        $client = $this->createClient();

        $client->request('GET', '/');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testInvalidSubmit()
    {
        $params = array(
            'name'    => 'User name',
            'subject' => 'Hi there',
            'message' => 'Testing...',
        );

        $client = $this->createClient();
        $client->request('POST', '/contact', array('form' => $params), array(), array());

        $this->assertContains('The field is required.', $client->getResponse()->getContent());
    }

    protected function createBundle()
    {
        return new \MyApp\MyAppBundle;
    }

}
