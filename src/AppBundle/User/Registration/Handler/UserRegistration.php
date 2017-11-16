<?php

namespace AppBundle\User\Registration\Handler;

use AppBundle\Common\Handler\Handler;
use AppBundle\User\Entity\User;
use AppBundle\User\Registration\AuthenticatorHandler;
use AppBundle\User\Registration\Command\UserRegistration as Command;
use AppBundle\User\Repository\Users;

class UserRegistration implements Handler
{
    private $users;
    private $authenticatorHandler;

    public function __construct(Users $users, AuthenticatorHandler $authenticatorHandler)
    {
        $this->users = $users;
        $this->authenticatorHandler = $authenticatorHandler;
    }

    /**
     * @param Command $registration
     */
    public function handle($registration)
    {
        $user = User::createFromRegistration($registration);
        $this->users->save($user);
        //$this->authenticatorHandler->authenticateUserAndHandleSuccess($user);
    }
}
