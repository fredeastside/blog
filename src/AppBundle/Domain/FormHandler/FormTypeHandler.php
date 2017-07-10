<?php

namespace AppBundle\Domain\FormHandler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistrationTypeHandler
 *
 * @package AppBundle\FormHandler
 */
class FormTypeHandler implements FormTypeHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return bool
     */
    public function handle(FormInterface $form, Request $request) : bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return true;
        }

        return false;
    }
}
