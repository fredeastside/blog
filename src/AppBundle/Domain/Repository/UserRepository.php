<?php

namespace AppBundle\Domain\Repository;

use AppBundle\Domain\Entity\User;
use AppBundle\Domain\Interfaces\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 *
 * @package AppBundle\Repository
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function remove(User $user) : void
    {
        $this->getEntityManager()->remove($user);
    }
}
