<?php

namespace App\Domain;

use AppBundle\Domain\Entity\User;

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * @param User $user
     */
    public function save(User $user);
}
