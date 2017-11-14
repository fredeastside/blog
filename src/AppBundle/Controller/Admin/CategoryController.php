<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Category\Add\Form\AddCategoryType;
use AppBundle\Category\Entity\Category;
use AppBundle\Common\Service\FileUpload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/category")
 */
class CategoryController extends Controller
{
    private $fileUpload;

    public function __construct(FileUpload $fileUpload)
    {
        $this->fileUpload = $fileUpload;
    }

    /**
     * @Route("/add", name="admin_category_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(AddCategoryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $addCategory = $form->getData();
            $this->fileUpload->upload($addCategory->picture);
            $category = new Category($addCategory->name, $this->fileUpload->fileName());
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Категория добавлена.');
        }

        return $this->render(':admin/category:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}