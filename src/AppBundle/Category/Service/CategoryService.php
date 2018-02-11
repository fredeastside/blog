<?php

declare(strict_types=1);

namespace AppBundle\Category\Service;

use AppBundle\Category\Entity\Category;
use AppBundle\Category\Form\CategoryDTO;

interface CategoryService
{
    public function add(CategoryDTO $categoryDTO);

    public function update(Category $category, CategoryDTO $addCategoryCommand);

    public function remove(Category $category);

    public function getAll();

    public function getDTOByCategory(Category $category);
}
