<?php

namespace AppBundle\Domain\Security;

use AppBundle\Domain\Form\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Class LoginFormAuthenticator
 *
 * @package AppBundle\Security
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $router;
    private $formFactory;
    private $passwordEncoder;

    /**
     * LoginFormAuthenticator constructor.
     *
     * @param RouterInterface      $router
     * @param FormFactoryInterface $formFactory
     * @param UserPasswordEncoder  $passwordEncoder
     */
    public function __construct(
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        UserPasswordEncoder $passwordEncoder
    ) {
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials(Request $request)
    {
        if (!$request->isMethod('POST') && $request->getPathInfo() !== $this->router->generate('login')) {
            return null;
        }

        $form = $this->formFactory->create(LoginType::class);
        $form->handleRequest($request);
        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;
    }

    /**
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['_username']);
    }

    /**
     * @param mixed         $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }
}
