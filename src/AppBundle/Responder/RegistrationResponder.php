<?php

namespace AppBundle\Responder;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class RegistrationResponder
 *
 * @package AppBundle\Responder
 */
class RegistrationResponder
{
    private $engine;

    /**
     * RegistrationResponder constructor.
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param FormInterface $form
     *
     * @return Response
     */
    public function __invoke(FormInterface $form) : Response
    {
        return new Response($this->engine->render(':registration:registration.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}