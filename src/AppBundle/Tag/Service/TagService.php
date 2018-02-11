<?php

declare(strict_types=1);

namespace AppBundle\Tag\Service;

use AppBundle\Tag\Entity\Tag;
use AppBundle\Tag\Form\TagDTO;

interface TagService
{
    public function getAll();

    public function add(TagDTO $tagDTO);

    public function update(Tag $tag, TagDTO $tagDTO);

    public function remove(Tag $tag);

    public function getDTOByTag(Tag $tag);
}