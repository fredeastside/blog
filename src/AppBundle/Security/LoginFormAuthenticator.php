<?php

namespace AppBundle\Security;

use AppBundle\Command\UserLogin;
use AppBundle\Form\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
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
        if (!$request->isMethod('POST') && $request->getPathInfo() !== $this->router->generate('login')) {
            return null;
        }

        $form = $this->formFactory->create(LoginType::class);
        $form->handleRequest($request);
        /** @var UserLogin $data */
        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data->username ?? null
        );

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

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }
}
