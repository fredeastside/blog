<?php

namespace AppBundle\User\Security;

use AppBundle\User\Login\Command\UserLogin;
use AppBundle\User\Login\Form\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\AuthenticatorInterface;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator implements AuthenticatorInterface
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
        if ($this->isNotPost($request) || $this->isNotLoginRoute($request)) {
            return null;
        }

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
        return parent::onAuthenticationSuccess($request, $token, $providerKey);
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }

    private function isNotPost(Request $request): bool
    {
        return !$request->isMethod('POST');
    }

    private function isNotLoginRoute(Request $request): bool
    {
        return $request->getPathInfo() !== $this->router->generate('login');
    }

    private function getLoginFormData(Request $request): UserLogin
    {
        $form = $this->formFactory->create(LoginType::class);
        $form->handleRequest($request);
        /** @var UserLogin $data */
        $data = $form->getData();

        return $data;
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
        // TODO: Implement supports() method.
    }
}
