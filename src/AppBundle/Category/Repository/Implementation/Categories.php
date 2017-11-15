<?php

namespace AppBundle\Category\Repository\Implementation;

use AppBundle\Category\Entity\Category;
use AppBundle\Category\Repository\Categories as CategoriesInterface;
use AppBundle\Common\Repository\Implementation\Repository;

class Categories extends Repository implements CategoriesInterface
{
    public function save(Category $category)
    {
        $this->em->persist($category);
        $this->em->flush();
    }

    public function getEntityClass()
    {
        return Category::class;
    }
}