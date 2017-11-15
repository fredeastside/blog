<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Tag\Add\Form\AddTagType;
use AppBundle\Tag\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/tag")
 */
class TagController extends Controller
{
    /**
     * @Route("/add", name="admin_tag_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(AddTagType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $addTag = $form->getData();
            $tag = new Tag($addTag->name);
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
            $this->addFlash('success', 'Тег добавлен.');
        }

        return $this->render(':admin/tag:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}