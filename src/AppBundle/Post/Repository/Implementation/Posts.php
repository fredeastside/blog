<?php

namespace AppBundle\Post\Repository\Implementation;

use AppBundle\Common\Repository\Implementation\Repository;
use AppBundle\Post\Entity\Post;
use AppBundle\Post\Repository\Posts as PostsInterface;

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
}