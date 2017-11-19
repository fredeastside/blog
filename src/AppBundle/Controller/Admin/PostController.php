<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Post\Add\Form\AddPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/add", name="admin_post_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(AddPostType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render(':admin/post:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}