<?php

namespace AppBundle\Responder;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class LoginResponder
 *
 * @package AppBundle\Responder
 */
class LoginResponder
{
    private $engine;

    /**
     * LoginResponder constructor.
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param null|AuthenticationException $error
     * @param FormInterface                $form
     *
     * @return Response
     */
    public function __invoke(?AuthenticationException $error, FormInterface $form) : Response
    {
        return new Response($this->engine->render(':login:login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]));
    }
}