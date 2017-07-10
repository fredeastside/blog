<?php

namespace AppBundle\Action;

use App\Domain\UserRepositoryInterface;
use AppBundle\Domain\Entity\User;
use AppBundle\Domain\Form\RegistrationType;
use AppBundle\Domain\FormHandler\FormTypeHandlerInterface;
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
     * @var FormTypeHandlerInterface
     */
    private $handler;
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * Registration constructor.
     *
     * @param FormFactoryInterface     $formFactory
     * @param RegistrationResponder    $responder
     * @param FormTypeHandlerInterface $handler
     * @param UserRepositoryInterface  $repository
     */
    public function __construct(FormFactoryInterface $formFactory, RegistrationResponder $responder, FormTypeHandlerInterface $handler, UserRepositoryInterface $repository)
    {
        $this->formFactory = $formFactory;
        $this->responder = $responder;
        $this->handler = $handler;
        $this->repository = $repository;
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
            $user = User::register($form->getData());
            $this->repository->save($user);
        }

        return $responder($form);
    }
}
