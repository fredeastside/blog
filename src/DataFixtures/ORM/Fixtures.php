<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $objects = $loader->loadFile(__DIR__.'/../fixtures.yml');
        $persister = new Persister($manager);
        $persister->persist($objects->getObjects());

        return $objects->getObjects();
    }
}