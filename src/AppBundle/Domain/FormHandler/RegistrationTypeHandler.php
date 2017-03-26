<?php

namespace AppBundle\Domain\FormHandler;

use AppBundle\Domain\Interfaces\Form\TypeHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistrationTypeHandler
 *
 * @package AppBundle\FormHandler
 */
class RegistrationTypeHandler implements TypeHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return bool
     */
    public function handle(FormInterface $form, Request $request) : bool
    {
        if ($form->handleRequest($request)) {
            return true;
        }

        return false;
    }
}
