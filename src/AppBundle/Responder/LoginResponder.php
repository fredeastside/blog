<?php

namespace AppBundle\Responder;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Templating\EngineInterface;

class LoginResponder
{
    private $templateEngine;

    public function __construct(EngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(?AuthenticationException $error, FormInterface $form) : Response
    {
        return new Response($this->templateEngine->render(':login:login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]));
    }
}