<?php

namespace AppBundle\Category\Repository;

use AppBundle\Category\Entity\Category;

interface Categories
{
    public function save(Category $category);

    public function findAll();
}