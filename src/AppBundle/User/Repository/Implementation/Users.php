<?php

namespace AppBundle\User\Repository\Implementation;

use AppBundle\User\Entity\User;
use AppBundle\User\Repository\Users as UsersInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class Users implements UsersInterface
{
    private $em;
    private $repository;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->em = $managerRegistry->getManagerForClass($this->getEntityClass());
        $this->repository = $managerRegistry->getRepository($this->getEntityClass());
    }

    public function findById($id)
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function save(UserInterface $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function getEntityClass()
    {
        return User::class;
    }
}
