<?php

namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegistrationTest
 *
 * @package AppBundle\Action
 */
class RegistrationTest extends WebTestCase
{
    /** @var Router */
    private $router;
    private $client;

    /**
     * @test
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }
    /**
     * @test
     */
    public function testPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $this->router->generate('registration'));
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('Регистрация', $crawler->filter('.container h3')->text());
    }

    /**
     * @test
     */
    public function testForm()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', $this->router->generate('registration'), [
            'registration' => [
                'email' => 'test@test.test',
                'plainPassword' => [
                    'first' => '123456',
                    'second' => '123456',
                ],
            ],
        ]);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertContains('Регистрация', $crawler->filter('.container h3')->text());
    }
}
