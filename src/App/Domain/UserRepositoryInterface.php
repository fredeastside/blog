<?php

namespace App\Domain;

use AppBundle\Entity\User;

interface UserRepositoryInterface
{
    public function findById($id);

    public function save(User $user);
}
