<?php

namespace AppBundle\User\Registration\Command;

class UserActivation
{
    private $activationCode;

    public function __construct($activationCode)
    {
        $this->activationCode = $activationCode;
    }

    public function activationCode()
    {
        return $this->activationCode;
    }
}
