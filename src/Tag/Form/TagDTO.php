<?php

declare(strict_types=1);

namespace App\Tag\Form;

use Symfony\Component\Validator\Constraints\NotBlank;

class TagDTO
{
    /**
     * @NotBlank()
     */
    public $name;
}