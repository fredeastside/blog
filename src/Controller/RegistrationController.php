<?php

namespace App\Controller;

use App\User\Registration\AuthenticatorHandler;
use App\User\Registration\Command\UserActivation;
use App\User\Registration\Form\RegistrationType;
use App\User\Repository\Users;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registration")
 */
class RegistrationController extends AbstractController
{
    private $messageBus;
    private $authenticatorHandler;
    private $users;

    public function __construct(MessageBus $messageBus, AuthenticatorHandler $authenticatorHandler, Users $users)
    {
        $this->messageBus = $messageBus;
        $this->authenticatorHandler = $authenticatorHandler;
        $this->users = $users;
    }

    /**
     * @Route("/", name="registration", methods={"GET", "POST"})
     */
    public function registrationAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageBus->handle($form->getData());
            $this->addFlash('success', 'На вашу почту отправлено письмо для активации аккаунта.');
        }

        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{activationCode}", name="registration_activation", methods={"GET"})
     */
    public function activationAction(string $activationCode)
    {
        $this->messageBus->handle(new UserActivation($activationCode));
        $this->addFlash('success', 'Пользователь успешно активирован. Введите данные для входа.');

        return $this->redirectToRoute('login');
    }
}