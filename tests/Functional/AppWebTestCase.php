<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\DataFixtures\ORM\Fixtures;
use App\User\Entity\Role;
use App\User\Registration\MainAuthenticatorHandlerDecorator;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

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

    protected function loadFixtures()
    {
        return (new Fixtures())->load($this->container->get('doctrine.orm.entity_manager'));
    }

    protected function logIn()
    {
        $session = $this->container->get('session');
        $firewallContext = MainAuthenticatorHandlerDecorator::MAIN_PROVIDER_KEY;
        $token = new UsernamePasswordToken('admin@admin.admin', null, $firewallContext, [Role::ROLE_ADMIN]);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}