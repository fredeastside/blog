<?php

declare(strict_types=1);

namespace AppBundle\Category\Service\Implementation;

use AppBundle\Category\Add\Command\AddCategory;
use AppBundle\Category\Entity\Category;
use AppBundle\Category\Form\CategoryDTO;
use AppBundle\Category\Repository\Categories;
use AppBundle\Common\Service\FileUpload;
use AppBundle\Category\Service\CategoryService as CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    private $categories;
    private $fileUpload;

    public function __construct(Categories $categories, FileUpload $fileUpload)
    {
        $this->categories = $categories;
        $this->fileUpload = $fileUpload;
    }

    public function add(CategoryDTO $categoryDTO)
    {
        $fileName = $this->fileUpload->upload($categoryDTO->picture);
        $category = new Category($categoryDTO->name, $fileName);
        $this->categories->save($category);
    }

    public function remove(Category $category)
    {
        $this->fileUpload->removeByPath($category->picture());
        $this->categories->remove($category);
    }

    public function getAll()
    {
        return $this->categories->findAll();
    }

    public function update(Category $category, CategoryDTO $categoryDTO)
    {
        $this->fileUpload->removeByPath($category->picture());
        $fileName = $this->fileUpload->upload($categoryDTO->picture);
        $category->update($categoryDTO->name, $fileName);
        $this->categories->save($category);
    }

    public function getDTOByCategory(Category $category)
    {
        $dto = new CategoryDTO();
        $dto->name = $category->name();
        $dto->picture = $this->fileUpload->getFileByName($category->picture());

        return $dto;
    }
}