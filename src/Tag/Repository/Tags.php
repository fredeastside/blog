<?php

namespace App\Tag\Repository;

use App\Tag\Entity\Tag;

interface Tags
{
    public function findAll();

    public function save(Tag $tag);

    public function remove(Tag $tag);
}