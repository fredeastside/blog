<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends Controller
{
    /**
     * @Route("/", name="homepage_index", methods={"GET"})
     */
    public function indexAction()
    {
        return $this->render(':homepage:index.html.twig');
    }
}