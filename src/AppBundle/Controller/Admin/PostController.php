<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin/post")
 */
class PostController extends Controller
{
    /**
     * @Route("/add", name="admin_post_add", methods={"GET", "POST"})
     */
    public function addAction(Request $request)
    {

    }
}