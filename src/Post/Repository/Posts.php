<?php

namespace App\Post\Repository;

use App\Post\Entity\Post;

interface Posts
{
    public function save(Post $post);

    public function findAll();

    public function remove(Post $post);
}