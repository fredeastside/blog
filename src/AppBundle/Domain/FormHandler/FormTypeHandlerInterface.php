<?php

namespace AppBundle\Domain\FormHandler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface TypeHandlerInterface
 *
 * @package AppBundle\Interfaces\Form
 */
interface FormTypeHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return bool
     */
    public function handle(FormInterface $form, Request $request) : bool;
}
