<?php

namespace AppBundle\Domain\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegistration
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\NotBlank()
     */
    public $plainPassword;
}
