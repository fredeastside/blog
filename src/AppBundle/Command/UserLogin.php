<?php

namespace AppBundle\Command;

use Symfony\Component\Validator\Constraints\NotBlank;

class UserLogin
{
    /**
     * @NotBlank
     */
    public $username;

    /**
     * @NotBlank
     */
    public $password;
}