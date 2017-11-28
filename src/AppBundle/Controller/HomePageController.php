<?php

namespace AppBundle\Controller;

use AppBundle\Category\Repository\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="homepage_index", methods={"GET"})
     */
    public function indexAction(Categories $categories)
    {
        return $this->render(':homepage:index.html.twig', [
            'categories' => $categories->findAll(),
        ]);
    }

    /**
     * @Route("/about", name="homepage_about")
     */
    public function aboutAction()
    {
        return $this->render(':homepage:about.html.twig');
    }
}