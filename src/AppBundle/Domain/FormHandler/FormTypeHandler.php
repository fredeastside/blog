<?php

namespace AppBundle\Domain\FormHandler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormTypeHandler implements FormTypeHandlerInterface
{
    public function handle(FormInterface $form, Request $request) : bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return true;
        }

        return false;
    }
}
