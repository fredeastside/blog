<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="homepage_index", methods={"GET"})
     */
    public function indexAction()
    {
        return $this->render(':homepage:index.html.twig');
    }

    /**
     * @Route("/about", name="homepage_about")
     */
    public function aboutAction()
    {
        return $this->render(':homepage:about.html.twig');
    }
}