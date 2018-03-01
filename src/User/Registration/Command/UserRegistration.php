<?php

namespace App\User\Registration\Command;

use Symfony\Component\Validator\Constraints\{
    NotBlank,
    Email
};

class UserRegistration
{
    /**
     * @NotBlank()
     * @Email()
     */
    public $email;

    /**
     * @NotBlank()
     */
    public $plainPassword;
}
