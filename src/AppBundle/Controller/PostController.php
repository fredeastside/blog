<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/post/{slug}", name="post_detail")
     */
    public function detailAction()
    {
        return $this->render(':post:detail.html.twig');
    }
}