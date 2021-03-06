<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionController extends AbstractController
{
    /**
     * @Route("/subscription", name="subscription", methods={"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('subscription/subscription.html.twig');
    }
}