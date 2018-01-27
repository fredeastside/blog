<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Category\Add\Command\AddCategory;
use AppBundle\Category\Add\Form\AddCategoryType;
use AppBundle\Category\Entity\Category;
use AppBundle\Category\Repository\Categories;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/category")
 */
class CategoryController extends Controller
{
    private $messageBus;

    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/", name="admin_category_list", methods={"GET"})
     * @param Categories $categories
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Categories $categories)
    {
        return $this->render(':admin/category:list.html.twig', [
            'categories' => $categories->findAll()
        ]);
    }

    /**
     * @Route("/add", name="admin_category_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->handleForm($request);
        if ($this->submitForm($form, 'Категория создана.')) {
            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render(':admin/category:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{category}", name="admin_category_edit", methods={"GET", "POST"})
     */
    public function editAction(Category $category, Request $request)
    {
        $category = $this->getCategoryCommand($category);
        $form = $this->handleForm($request, $category);
        if ($this->submitForm($form, 'Категория обновлена.')) {
            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render(':admin/category:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function getCategoryCommand(Category $category): AddCategory
    {
        $category = AddCategory::fromCategory($category);
        $category->picture = new File($this->getParameter('upload_dir').'/'.$category->picture);

        return $category;
    }

    private function handleForm(Request $request, ?AddCategory $category = null): FormInterface
    {
        $form = $this->createForm(AddCategoryType::class, $category);
        $form->handleRequest($request);

        return $form;
    }

    private function submitForm(FormInterface $form, string $flashMessage): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageBus->handle($form->getData());
            $this->addFlash('success', $flashMessage);

            return true;
        }

        return false;
    }
}