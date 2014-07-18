<?php

/*
 * This file is part of MyApp\Tests package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

namespace MyApp\Tests;

/**
 * ContactUsTest is the functionality of the contact us form.
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 */
class ContactUsTest extends \Moo\Silex\WebTestCase
{

    public function testFormSuccessful()
    {
        $response = $this->formRequest(array(
            'name'    => 'John Doe',
            'email'   => 'john@doe.com',
            'subject' => 'Who am I?',
            'message' => 'I want to know, who am I?',
        ));

        $this->assertContains('Thank You', $response);
    }

    public function testFormValidationMessageShort()
    {
        $response = $this->formRequest(array(
            'name'    => 'John Doe',
            'email'   => 'john@doe.com',
            'subject' => 'Question?',
            'message' => 'I',
        ));

        $this->assertContains('The message field is too short!', $response);
    }

    public function testFormValidationEmail()
    {
        $response = $this->formRequest(array(
            'name'    => 'John Doe',
            'email'   => 'doe.com',
            'subject' => 'Question?',
            'message' => 'I have a question to ask...',
        ));

        $this->assertRegExp('/The email (.*?) is not a valid email./', $response);
    }

    protected function formRequest($params)
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request('POST', '/contact', array('form' => $params), array(), array());

        return $client->getResponse()->getContent();
    }

    protected function createBundle()
    {
        return new \MyApp\MyAppBundle;
    }

}
