<?php

/*
 * This file is part of MyApp\Controller package.
 *
 * (c) Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 *
 */

namespace MyApp\Controller;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;

/**
 * IndexController is the default frontend controller
 *
 * @author Mohamed Alsharaf <mohamed.alsharaf@gmail.com>
 */
class IndexController extends \Moo\Silex\AbstractController
{

    /**
     * Main site page
     *
     * @return Response
     */
    public function indexAction($name)
    {
        return $this->render('index', array('name' => $name));
    }

    /**
     * Main site page
     *
     * @return Response
     */
    public function contactAction()
    {
        $form = $this->getContactForm();
        $form->handleRequest($this->app['request']);
        $data = array(
            'form' => $form->createView()
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $data['message_type'] = 'success';
            $data['message'] = 'Your message have successfully sent to us. Thank You.';
            if (!$this->sendEmail($form->getData())) {
                $data['message_type'] = 'error';
                $data['message'] = 'Your message failed to be sent.';
            }
        }

        return $this->render('contact', $data);
    }

    /**
     * Returns an instance of the contact form
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function getContactForm()
    {
        $notBlank = new Assert\NotBlank(array('message' => 'The field is required.',));

        $builder = $this->app['form.factory']->createBuilder('form', null, array('csrf_protection' => false));
        $form = $builder
                ->add('name', 'text', array(
                    'constraints' => array(
                        $notBlank
                    ),
                ))
                ->add('email', 'email', array(
                    'constraints' => array(
                        $notBlank,
                        new Assert\Email(array(
                            'message' => 'The email "{{ value }}" is not a valid email.',
                            'checkMX' => true,)
                        )
                    ),
                ))
                ->add('subject', 'text', array(
                    'constraints' => array(
                        $notBlank
                    ),
                ))
                ->add('message', 'textarea', array(
                    'constraints' => array(
                        $notBlank,
                        new Assert\Length(array(
                            'min'        => 5,
                            'minMessage' => 'The message field is too short!',)
                        )
                    ),
                ))
                ->add('send', 'submit', array('attr' => array('class' => 'btn-lg btn-block btn-primary')))
                ->getForm()
        ;

        return $form;
    }

    /**
     * Send email
     *
     * @return boolean
     */
    protected function sendEmail($data)
    {
        // message body
        $body = '<html>'
                . '<head></head>'
                . '<body>'
                . 'Name: ' . $data['name'] . '<br />'
                . 'Email: ' . $data['email'] . '<br />'
                . 'IP: ' . $this->app['request']->getClientIp() . '<br /><br />'
                . 'Message:<br /><br />' . nl2br($data['message'])
                . '</body>'
                . '</html>';

        // setup mailer message
        $message = \Swift_Message::newInstance()
                ->setSubject($this->app['myshortname'] . " - " . $data['subject'])
                ->setFrom(array($data['email'] => $data['name']))
                ->setTo(array($this->app['myemail']))
                ->setBody($body, 'text/html');

        // setup mailer
        $transport = \Swift_MailTransport::newInstance();
        $mailer = \Swift_Mailer::newInstance($transport);

        // send
        return $mailer->send($message);
    }

}
