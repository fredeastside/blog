<?php

namespace App\Test;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AppTestCase
 *
 * @package Test
 */
class AppTestCase extends WebTestCase
{
    /** @var Router */
    protected $router;
    /** @var Client */
    protected $client;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }

    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        $this->client = null;
        $this->router = null;
    }
}
