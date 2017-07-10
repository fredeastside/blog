<?php

namespace AppBundle\Domain\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRegistration
 *
 * @package AppBundle\Domain\Form
 */
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
