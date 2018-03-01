<?php

namespace App\Tag\Repository\Implementation;

use App\Common\Repository\Implementation\Repository;
use App\Tag\Entity\Tag;
use App\Tag\Repository\Tags as TagsInterface;

class Tags extends Repository implements TagsInterface
{
    public function getEntityClass()
    {
        return Tag::class;
    }

    public function save(Tag $tag)
    {
        $this->em->persist($tag);
        $this->em->flush();
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function remove(Tag $tag)
    {
        $this->em->remove($tag);
        $this->em->flush();
    }
}