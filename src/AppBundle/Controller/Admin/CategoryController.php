<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Category\Form\CategoryDTO;
use AppBundle\Category\Form\CategoryType;
use AppBundle\Category\Entity\Category;
use AppBundle\Category\Service\CategoryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/category")
 */
class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @Route("/", name="admin_category_list", methods={"GET"})
     */
    public function listAction()
    {
        return $this->render(':admin/category:list.html.twig', [
            'categories' => $this->categoryService->getAll()
        ]);
    }

    /**
     * @Route("/add", name="admin_category_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->handleForm($request);
        $callback = function(CategoryDTO $data) {
            $this->categoryService->add($data);
        };
        if ($this->submitForm($form, $callback, 'Категория создана.')) {
            return $this->redirectToList();
        }

        return $this->responseWithForm($form, ':admin/category:add.html.twig');
    }

    /**
     * @Route("/edit/{category}", name="admin_category_edit", methods={"GET", "POST"})
     */
    public function editAction(Category $category, Request $request)
    {
        $form = $this->handleForm($request, $this->categoryService->getDTOByCategory($category));
        $callback = function(CategoryDTO $data) use($category) {
            $this->categoryService->update($category, $data);
        };
        if ($this->submitForm($form, $callback, 'Категория обновлена.')) {
            return $this->redirectToList();
        }

        return $this->responseWithForm($form, ':admin/category:edit.html.twig');
    }

    /**
     * @Route("/delete/{category}", name="admin_category_delete", methods={"GET"})
     */
    public function deleteAction(Category $category)
    {
        $this->categoryService->remove($category);

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

    private function handleForm(Request $request, ?CategoryDTO $category=null): FormInterface
    {
        $form = $this->createForm(CategoryType::class, $category);
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
        return $this->redirectToRoute('admin_category_list');
    }
}