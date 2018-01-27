<?php

namespace AppBundle\Category\Add\Command;

use AppBundle\Category\Entity\Category;
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

    public static function fromCategory(Category $category)
    {
        $dto = new self;
        $dto->name = $category->name();
        $dto->picture = $category->picture();

        return $dto;
    }
}