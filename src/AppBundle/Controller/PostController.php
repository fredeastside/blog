<?php

namespace AppBundle\Controller;

use AppBundle\Post\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/{slug}", name="post_detail")
     */
    public function detailAction(Post $post)
    {
        return $this->render(':post:detail.html.twig', [
            'post' => $post,
        ]);
    }
}