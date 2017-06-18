<?php

namespace AppBundle\Action;

use AppBundle\Domain\Form\RegistrationType;
use AppBundle\Domain\Interfaces\Form\TypeHandlerInterface;
use AppBundle\Responder\RegistrationResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Registration
 *
 * @package AppBundle\Action
 */
final class Registration
{
    private $formFactory;
    private $responder;
    /**
     * @var TypeHandlerInterface
     */
    private $handler;

    /**
     * Registration constructor.
     *
     * @param FormFactoryInterface  $formFactory
     * @param RegistrationResponder $responder
     * @param TypeHandlerInterface  $handler
     */
    public function __construct(FormFactoryInterface $formFactory, RegistrationResponder $responder, TypeHandlerInterface $handler)
    {
        $this->formFactory = $formFactory;
        $this->responder = $responder;
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request) : Response
    {
        $responder = $this->responder;
        $form = $this->formFactory->create(RegistrationType::class);

        if ($this->handler->handle($form, $request)) {
            dump($form->getData());die;
        }

        return $responder($form);
    }
}
