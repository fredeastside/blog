<?php

namespace App\Category\Repository;

use App\Category\Entity\Category;

interface Categories
{
    public function save(Category $category);

    public function remove(Category $category);

    public function findAll();
}