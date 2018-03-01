<?php

declare(strict_types=1);

namespace App\Category\Service;

use App\Category\Entity\Category;
use App\Category\Form\CategoryDTO;

interface CategoryService
{
    public function add(CategoryDTO $categoryDTO);

    public function update(Category $category, CategoryDTO $addCategoryCommand);

    public function remove(Category $category);

    public function getAll();

    public function getDTOByCategory(Category $category);
}
