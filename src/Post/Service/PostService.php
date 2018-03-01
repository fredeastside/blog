<?php

declare(strict_types=1);

namespace App\Post\Service;

use App\Post\Entity\Post;
use App\Post\Form\PostDTO;

interface PostService
{
    public function getAll();

    public function add(PostDTO $postDTO);

    public function getDTOByPost(Post $post);

    public function update(Post $post, PostDTO $data);

    public function remove(Post $post);
}