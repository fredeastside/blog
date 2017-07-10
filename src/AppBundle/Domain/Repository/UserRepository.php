<?php

namespace AppBundle\Domain\Repository;

use App\Domain\UserRepositoryInterface;
use AppBundle\Domain\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 *
 * @package AppBundle\Repository
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return mixed
     */
    public function findById($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @param User $user
     */
    public function save(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
