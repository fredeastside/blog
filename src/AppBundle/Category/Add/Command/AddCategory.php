<?php

namespace AppBundle\Category\Add\Command;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class AddCategory
{
    /**
     * @NotBlank
     */
    public $name;

    /**
     * @NotBlank
     * @File(mimeTypes={ "image/jpeg", "image/jpg", "image/png" }, maxSize="2048k")
     */
    public $picture;
}