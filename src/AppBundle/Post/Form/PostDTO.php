<?php

declare(strict_types=1);

namespace AppBundle\Post\Form;

use Symfony\Component\Validator\Constraints\NotBlank;

class PostDTO
{
    /**
     * @NotBlank()
     */
    public $name;

    /**
     * @NotBlank()
     */
    public $content;

    /**
     * @NotBlank()
     */
    public $description;

    /**
     * @NotBlank()
     */
    public $category;

    /**
     * @NotBlank()
     */
    public $tags;
}