<?php

namespace App\Controller\Admin;

use App\Post\Add\Form\AddPostType;
use App\Post\Entity\Post;
use App\Post\Form\PostDTO;
use App\Post\Form\PostType;
use App\Post\Service\PostService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/post")
 */
class PostController extends AbstractController
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @Route("/", name="admin_post_list", methods={"GET"})
     */
    public function listAction()
    {
        return $this->render('admin/post/list.html.twig', [
            'posts' => $this->postService->getAll()
        ]);
    }

    /**
     * @Route("/add", name="admin_post_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->handleForm($request);
        $callback = function(PostDTO $data) {
            $this->postService->add($data);
        };
        if ($this->submitForm($form, $callback, 'Пост добавлен.')) {
            return $this->redirectToList();
        }

        return $this->responseWithForm($form, 'admin/post/add.html.twig');
    }

    /**
     * @Route("/edit/{post}", name="admin_post_edit", methods={"GET", "POST"})
     */
    public function editAction(Post $post, Request $request)
    {
        $form = $this->handleForm($request, $this->postService->getDTOByPost($post));
        $callback = function(PostDTO $data) use($post) {
            $this->postService->update($post, $data);
        };
        if ($this->submitForm($form, $callback, 'Пост обновлен.')) {
            return $this->redirectToList();
        }

        return $this->responseWithForm($form, 'admin/post/edit.html.twig');
    }

    /**
     * @Route("/delete/{post}", name="admin_post_delete", methods={"GET"})
     */
    public function deleteAction(Post $post)
    {
        $this->postService->remove($post);

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

    private function handleForm(Request $request, ?PostDTO $postDTO=null): FormInterface
    {
        $form = $this->createForm(PostType::class, $postDTO);
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
        return $this->redirectToRoute('admin_post_list');
    }
}