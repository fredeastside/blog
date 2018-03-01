<?php

namespace App\Common\Repository\Implementation;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;

abstract class Repository
{
    /** @var EntityManager */
    protected $em;
    protected $repository;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->em = $managerRegistry->getManagerForClass($this->getEntityClass());
        $this->repository = $managerRegistry->getRepository($this->getEntityClass());
    }

    abstract public function getEntityClass();
}