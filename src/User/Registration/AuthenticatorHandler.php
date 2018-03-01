<?php

namespace App\User\Registration;

use Symfony\Component\Security\Core\User\UserInterface;

interface AuthenticatorHandler
{
    public function authenticateUserAndHandleSuccess(UserInterface $user);
}