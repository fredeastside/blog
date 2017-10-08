<?php

namespace AppBundle\Repository;

use App\Domain\UserRepositoryInterface;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
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
