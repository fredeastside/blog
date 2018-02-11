<?php

namespace AppBundle\Tag\Repository;

use AppBundle\Tag\Entity\Tag;

interface Tags
{
    public function findAll();

    public function save(Tag $tag);

    public function remove(Tag $tag);
}