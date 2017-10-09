<?php

namespace AppBundle\User\Repository;

use AppBundle\Entity\User;

interface Users
{
    public function findById($id);

    public function save(User $user);
}
