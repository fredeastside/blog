<?php

declare(strict_types=1);

namespace App\Tag\Service;

use App\Tag\Entity\Tag;
use App\Tag\Form\TagDTO;

interface TagService
{
    public function getAll();

    public function add(TagDTO $tagDTO);

    public function update(Tag $tag, TagDTO $tagDTO);

    public function remove(Tag $tag);

    public function getDTOByTag(Tag $tag);
}