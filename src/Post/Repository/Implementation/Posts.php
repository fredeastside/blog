<?php

namespace App\Post\Repository\Implementation;

use App\Category\Entity\Category;
use App\Common\Repository\Implementation\Repository;
use App\Post\Entity\Post;
use App\Post\Repository\Posts as PostsInterface;

class Posts extends Repository implements PostsInterface
{
    public function save(Post $post)
    {
        $this->em->persist($post);
        $this->em->flush();
    }

    public function getEntityClass()
    {
        return Post::class;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function remove(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush();
    }

    public function findByCategory(Category $category)
    {
        return $this->repository->findAll();
    }
}