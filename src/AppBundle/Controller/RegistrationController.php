<?php

namespace AppBundle\Controller;

use AppBundle\User\Registration\Form\RegistrationType;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    private $messageBus;

    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/registration", name="registration", methods={"GET", "POST"})
     */
    public function registrationAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageBus->handle($form->getData());
        }

        return $this->render(':registration:registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}