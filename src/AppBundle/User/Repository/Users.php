<?php

namespace AppBundle\User\Repository;

use AppBundle\Common\Repository\Repository;
use Symfony\Component\Security\Core\User\UserInterface;

interface Users extends Repository
{
    public function findById($id);

    public function save(UserInterface $user);
}
