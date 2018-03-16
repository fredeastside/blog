<?php

declare(strict_types=1);

namespace App\Controller;

use App\Category\Entity\Category;
use App\Post\Repository\Posts;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{slug}", name="category_detail")
     */
    public function detailAction(Category $category, Posts $posts)
    {
        $posts = $posts->findByCategory($category);

        return $this->render('category/detail.html.twig', [
            'posts' => $posts,
        ]);
    }
}