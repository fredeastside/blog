<?php

namespace AppBundle\Tag\Repository\Implementation;

use AppBundle\Common\Repository\Implementation\Repository;
use AppBundle\Tag\Entity\Tag;
use AppBundle\Tag\Repository\Tags as TagsInterface;

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