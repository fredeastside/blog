<?php

namespace App\User\Registration;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class MainAuthenticatorHandlerDecorator implements AuthenticatorHandler
{
    public const MAIN_PROVIDER_KEY = 'main';

    private $guardAuthenticatorHandler;
    private $authenticator;
    private $requestStack;

    public function __construct(GuardAuthenticatorHandler $guardAuthenticatorHandler, AuthenticatorInterface $authenticator, RequestStack $requestStack)
    {
        $this->guardAuthenticatorHandler = $guardAuthenticatorHandler;
        $this->authenticator = $authenticator;
        $this->requestStack = $requestStack;
    }

    public function authenticateUserAndHandleSuccess(UserInterface $user)
    {
        $token = $this->authenticator->createAuthenticatedToken($user, self::MAIN_PROVIDER_KEY);
        $this->guardAuthenticatorHandler->authenticateWithToken($token, $this->requestStack->getCurrentRequest());
    }
}