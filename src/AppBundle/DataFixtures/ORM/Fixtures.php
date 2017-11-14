<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\User\Entity\User;
use AppBundle\User\Registration\Command\UserRegistration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $dto = new UserRegistration();
        $dto->email = 'test@test.test';
        $dto->plainPassword = '123456';
        $user = User::createFromRegistration($dto);
        $user->activate();
        $dto = new UserRegistration();
        $dto->email = 'admin@admin.admin';
        $dto->plainPassword = '123456';
        $admin = User::createFromRegistration($dto);
        $admin->activate();
        $admin->toAdmin();
        $manager->persist($user);
        $manager->persist($admin);
        $manager->flush();
    }
}