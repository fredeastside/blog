<?php

namespace AppBundle\User\Repository;

use AppBundle\User\Entity\User;

interface Users
{
    public function findById($id);

    public function save(User $user);
}
