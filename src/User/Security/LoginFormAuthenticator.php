<?php

namespace App\User\Security;

use App\User\Login\Command\UserLogin;
use App\User\Login\Form\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $router;
    private $formFactory;
    private $passwordEncoder;

    public function __construct(
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        $data = $this->getLoginFormData($request);
        $request->getSession()->set(Security::LAST_USERNAME, $data->username ?? null);

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->passwordEncoder->isPasswordValid($user, $credentials->password)) {
            return true;
        }

        return false;
    }

    public function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage_index');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->getDefaultSuccessRedirectUrl());
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        if ($this->isPost($request) && $this->isLoginRoute($request)) {
            return true;
        }

        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }

    private function isPost(Request $request): bool
    {
        return $request->isMethod('POST');
    }

    private function isLoginRoute(Request $request): bool
    {
        return $request->getPathInfo() === $this->router->generate('login');
    }

    private function getLoginFormData(Request $request): UserLogin
    {
        $form = $this->formFactory->create(LoginType::class);
        $form->handleRequest($request);
        /** @var UserLogin $data */
        $data = $form->getData();

        return $data;
    }
}
