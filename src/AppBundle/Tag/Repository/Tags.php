<?php

namespace AppBundle\Tag\Repository;

use AppBundle\Tag\Entity\Tag;

interface Tags
{
    public function save(Tag $tag);
}