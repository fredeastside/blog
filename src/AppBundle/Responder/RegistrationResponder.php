<?php

namespace AppBundle\Responder;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class RegistrationResponder
{
    private $templateEngine;

    public function __construct(EngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function __invoke(FormInterface $form) : Response
    {
        return new Response($this->templateEngine->render(':registration:registration.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}