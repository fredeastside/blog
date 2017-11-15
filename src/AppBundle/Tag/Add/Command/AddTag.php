<?php

namespace AppBundle\Tag\Add\Command;

use Symfony\Component\Validator\Constraints\NotBlank;

class AddTag
{
    /**
     * @NotBlank()
     */
    public $name;
}