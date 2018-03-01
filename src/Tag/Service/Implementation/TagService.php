<?php

declare(strict_types=1);

namespace App\Tag\Service\Implementation;

use App\Tag\Entity\Tag;
use App\Tag\Form\TagDTO;
use App\Tag\Repository\Tags;
use App\Tag\Service\TagService as TagServiceInterface;

class TagService implements TagServiceInterface
{
    private $tags;

    public function __construct(Tags $tags)
    {
        $this->tags = $tags;
    }

    public function getAll()
    {
        return $this->tags->findAll();
    }

    public function add(TagDTO $tagDTO)
    {
        $tag = new Tag($tagDTO->name);
        $this->tags->save($tag);
    }

    public function update(Tag $tag, TagDTO $tagDTO)
    {
        $tag->update($tagDTO->name);
        $this->tags->save($tag);
    }

    public function remove(Tag $tag)
    {
        $this->tags->remove($tag);
    }

    public function getDTOByTag(Tag $tag)
    {
        $dto = new TagDTO();
        $dto->name = $tag->name();

        return $dto;
    }
}