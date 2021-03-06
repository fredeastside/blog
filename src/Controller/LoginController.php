<?php

namespace App\Controller;

use App\User\Login\Form\LoginType;
use App\User\Login\Command\UserLogin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function loginAction()
    {
        $dto = new UserLogin();
        $dto->username = $this->authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginType::class, $dto);

        $error = $this->authenticationUtils->getLastAuthenticationError();

        return $this->render('login/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logoutAction()
    {
        throw new \BadMethodCallException('This action can not be use.');
    }
}