<?php

declare(strict_types=1);

namespace AppBundle\Tag\Form;

use Symfony\Component\Validator\Constraints\NotBlank;

class TagDTO
{
    /**
     * @NotBlank()
     */
    public $name;
}