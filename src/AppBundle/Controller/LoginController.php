<?php

namespace AppBundle\Controller;

use AppBundle\Command\UserLogin;
use AppBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
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

        return $this->render(':login:login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}