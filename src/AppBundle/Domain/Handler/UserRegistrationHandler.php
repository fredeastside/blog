<?php

namespace AppBundle\Domain\Handler;

use App\Domain\UserRepositoryInterface;
use AppBundle\Domain\DataTransferObject\UserRegistration;
use AppBundle\Domain\Entity\User;

/**
 * Class UserRegistrationHandler
 *
 * @package AppBundle\Domain\Handler
 */
class UserRegistrationHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * UserRegistrationHandler constructor.
     *
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UserRegistration $registration
     */
    public function handle(UserRegistration $registration)
    {
        $user = User::register($registration);
        $this->repository->save($user);
    }
}
