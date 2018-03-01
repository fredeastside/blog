<?php

declare(strict_types=1);

namespace App\Category\Service\Implementation;

use App\Category\Entity\Category;
use App\Category\Form\CategoryDTO;
use App\Category\Repository\Categories;
use App\Category\Service\CategoryService as CategoryServiceInterface;
use App\Category\Service\UploadPicture;

class CategoryService implements CategoryServiceInterface
{
    private $categories;
    private $uploadPicture;

    public function __construct(Categories $categories, UploadPicture $uploadPicture)
    {
        $this->categories = $categories;
        $this->uploadPicture = $uploadPicture;
    }

    public function add(CategoryDTO $categoryDTO)
    {
        $fileName = $this->uploadPicture->upload($categoryDTO->picture);
        $category = new Category($categoryDTO->name, $fileName);
        $this->categories->save($category);
    }

    public function remove(Category $category)
    {
        $this->uploadPicture->remove($category);
        $this->categories->remove($category);
    }

    public function getAll()
    {
        return $this->categories->findAll();
    }

    public function update(Category $category, CategoryDTO $categoryDTO)
    {
        $this->uploadPicture->remove($category);
        $fileName = $this->uploadPicture->upload($categoryDTO->picture);
        $category->update($categoryDTO->name, $fileName);
        $this->categories->save($category);
    }

    public function getDTOByCategory(Category $category)
    {
        $dto = new CategoryDTO();
        $dto->name = $category->name();
        $dto->picture = $this->uploadPicture->getPictureFile($category);

        return $dto;
    }
}