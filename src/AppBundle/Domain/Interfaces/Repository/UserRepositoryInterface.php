<?php

namespace AppBundle\Domain\Interfaces\Repository;

use AppBundle\Domain\Entity\User;

/**
 * Interface UserRepositoryInterface
 *
 * @package AppBundle\Domain\Interfaces\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function add(User $user);

    /**
     * @param User $user
     *
     * @return void
     */
    public function remove(User $user) : void;
}
