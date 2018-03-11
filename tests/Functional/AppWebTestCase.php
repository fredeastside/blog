<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Client;

class AppWebTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var UrlGeneratorInterface
     */
    protected $router;
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->router = $this->container->get('router');
        $this->purgeDB();
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function purgeDB(): void
    {
        $purger = new ORMPurger($this->container->get('doctrine.orm.entity_manager'));
        $purger->purge();
    }
}