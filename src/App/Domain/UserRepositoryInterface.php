<?php

namespace App\Domain;

use AppBundle\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findById($id);

    public function save(User $user);
}
