<?php

namespace AppBundle\Post\Add\Command;

use Symfony\Component\Validator\Constraints\NotBlank;

class AddPost
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
    public $category;

    /**
     * @NotBlank()
     */
    public $tags;

    public $user;
}