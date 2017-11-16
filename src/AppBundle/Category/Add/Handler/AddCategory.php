<?php

namespace AppBundle\Category\Add\Handler;

use AppBundle\Category\Add\Command\AddCategory as Command;
use AppBundle\Category\Entity\Category;
use AppBundle\Category\Repository\Categories;
use AppBundle\Common\Handler\Handler;
use AppBundle\Common\Service\FileUpload;

class AddCategory implements Handler
{
    private $categories;
    private $fileUpload;

    public function __construct(Categories $categories, FileUpload $fileUpload)
    {
        $this->categories = $categories;
        $this->fileUpload = $fileUpload;
    }

    /**
     * @param Command $addCategoryCommand
     */
    public function handle($addCategoryCommand)
    {
        $this->fileUpload->upload($addCategoryCommand->picture);
        $category = new Category($addCategoryCommand->name, $this->fileUpload->fileName());
        $this->categories->save($category);
    }
}
