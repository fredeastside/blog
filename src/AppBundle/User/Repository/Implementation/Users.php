<?php

namespace AppBundle\User\Repository\Implementation;

use AppBundle\User\Entity\User;
use AppBundle\User\Repository\Users as UsersInterface;

class Users implements UsersInterface
{
    public function findById($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function save(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
