<?php

namespace AppBundle\Domain\Handler;

use App\Domain\UserRepositoryInterface;
use AppBundle\Domain\DataTransferObject\UserRegistration;
use AppBundle\Domain\Entity\User;

class UserRegistrationHandler
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(UserRegistration $registration)
    {
        $user = User::register($registration);
        $this->repository->save($user);
    }
}
