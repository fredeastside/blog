<?php

namespace AppBundle\User\Repository\Implementation;

use AppBundle\Common\Repository\Implementation\Repository;
use AppBundle\User\Entity\User;
use AppBundle\User\Repository\Users as UsersInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Users extends Repository implements UsersInterface
{
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

    public function findByEmail($email)
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function findByActivationCode($activationCode)
    {
        return $this->repository->findOneBy(['activationCode' => $activationCode]);
    }
}
