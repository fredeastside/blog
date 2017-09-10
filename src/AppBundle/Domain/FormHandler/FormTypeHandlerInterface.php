<?php

namespace AppBundle\Domain\FormHandler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface FormTypeHandlerInterface
{
    public function handle(FormInterface $form, Request $request) : bool;
}
