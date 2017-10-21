<?php

namespace AppBundle\User\Event;

use Symfony\Component\EventDispatcher\Event;

class SendActivationCode extends Event
{
    private $email;
    private $activationCode;

    public function __construct($email, $activationCode)
    {
        $this->email = $email;
        $this->activationCode = $activationCode;
    }

    public function email()
    {
        return $this->email;
    }

    public function activationCode()
    {
        return $this->activationCode;
    }
}