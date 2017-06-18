<?php

namespace AppBundle\Action;

use AppBundle\Domain\Form\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Responder\LoginResponder;

/**
 * Class Login
 *
 * @package AppBundle\Action
 */
final class Login
{
    private $authenticationUtils;
    private $responder;
    private $formFactory;

    /**
     * Login constructor.
     *
     * @param AuthenticationUtils  $authenticationUtils
     * @param FormFactoryInterface $formFactory
     * @param LoginResponder       $responder
     */
    public function __construct(
        AuthenticationUtils $authenticationUtils,
        FormFactoryInterface $formFactory,
        LoginResponder $responder
    ) {
        $this->authenticationUtils = $authenticationUtils;
        $this->responder = $responder;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request) : Response
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $form = $this->formFactory->create(LoginType::class, [
            '_username' => $this->authenticationUtils->getLastUsername(),
        ]);

        return ($this->responder)($error, $form);
    }
}
