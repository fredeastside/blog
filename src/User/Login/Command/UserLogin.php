<?php

namespace App\User\Login\Command;

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