<?php

declare(strict_types=1);

namespace App\Category\Form;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class CategoryDTO
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