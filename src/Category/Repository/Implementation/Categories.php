<?php

namespace App\Category\Repository\Implementation;

use App\Category\Entity\Category;
use App\Category\Repository\Categories as CategoriesInterface;
use App\Common\Repository\Implementation\Repository;

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

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function remove(Category $category)
    {
        $this->em->remove($category);
        $this->em->flush();
    }
}