<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Tag\Entity\Tag;
use AppBundle\Tag\Form\TagDTO;
use AppBundle\Tag\Form\TagType;
use AppBundle\Tag\Service\TagService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/tag")
 */
class TagController extends AbstractController
{
    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @Route("/", name="admin_tag_list", methods={"GET"})
     */
    public function listAction()
    {
        return $this->render(':admin/tag:list.html.twig', [
            'tags' => $this->tagService->getAll()
        ]);
    }

    /**
     * @Route("/add", name="admin_tag_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->handleForm($request);
        $callback = function(TagDTO $data) {
            $this->tagService->add($data);
        };
        if ($this->submitForm($form, $callback, 'Тег создан.')) {
            return $this->redirectToList();
        }

        return $this->responseWithForm($form, ':admin/tag:add.html.twig');
    }

    /**
     * @Route("/edit/{tag}", name="admin_tag_edit", methods={"GET", "POST"})
     */
    public function editAction(Tag $tag, Request $request)
    {
        $form = $this->handleForm($request, $this->tagService->getDTOByTag($tag));
        $callback = function(TagDTO $data) use($tag) {
            $this->tagService->update($tag, $data);
        };
        if ($this->submitForm($form, $callback, 'Тег обновлен.')) {
            return $this->redirectToList();
        }

        return $this->responseWithForm($form, ':admin/tag:edit.html.twig');
    }

    /**
     * @Route("/delete/{tag}", name="admin_tag_delete", methods={"GET"})
     */
    public function deleteAction(Tag $tag)
    {
        $this->tagService->remove($tag);

        return $this->redirectToList();
    }

    private function submitForm(FormInterface $form, callable $callback, string $message): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $callback($form->getData());
            $this->addFlash('success', $message);

            return true;
        }

        return false;
    }

    private function handleForm(Request $request, ?TagDTO $tagDTO=null): FormInterface
    {
        $form = $this->createForm(TagType::class, $tagDTO);
        $form->handleRequest($request);

        return $form;
    }

    private function responseWithForm(FormInterface $form, string $template)
    {
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

    private function redirectToList()
    {
        return $this->redirectToRoute('admin_tag_list');
    }
}