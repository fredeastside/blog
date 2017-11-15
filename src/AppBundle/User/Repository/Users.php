<?php

namespace AppBundle\User\Repository;

use Symfony\Component\Security\Core\User\UserInterface;

interface Users
{
    public function findById($id);

    public function findByEmail($email);

    public function save(UserInterface $user);

    public function findByActivationCode($activationCode);
}
