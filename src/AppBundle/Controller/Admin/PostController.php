<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Post\Add\Form\AddPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/post")
 */
class PostController extends AbstractController
{
    private $messageBus;

    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/add", name="admin_post_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(AddPostType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageBus->handle($form->getData());
            $this->addFlash('success', 'Пост добавлен.');
        }

        return $this->render(':admin/post:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}