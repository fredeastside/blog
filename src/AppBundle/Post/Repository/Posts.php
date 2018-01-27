<?php

namespace AppBundle\Post\Repository;

use AppBundle\Post\Entity\Post;

interface Posts
{
    public function save(Post $post);

    public function findAll();
}