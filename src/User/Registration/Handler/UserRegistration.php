<?php

namespace App\User\Registration\Handler;

use App\Common\Handler\Handler;
use App\User\Entity\User;
use App\User\Registration\AuthenticatorHandler;
use App\User\Registration\Command\UserRegistration as Command;
use App\User\Repository\Users;

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
