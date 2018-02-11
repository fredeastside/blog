<?php

declare(strict_types=1);

namespace AppBundle\Tag\Service\Implementation;

use AppBundle\Tag\Entity\Tag;
use AppBundle\Tag\Form\TagDTO;
use AppBundle\Tag\Repository\Tags;
use AppBundle\Tag\Service\TagService as TagServiceInterface;

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