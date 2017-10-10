<?php

namespace AppBundle\User\Registration\Handler;

use AppBundle\User\Registration\Command\UserRegistration as Command;

class UserRegistration
{
    public function handle(Command $registration)
    {
        dump($registration);die;
    }
}
