<?php

namespace AppBundle\Action;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class RegistrationTest
 *
 * @package AppBundle\Action
 */
class RegistrationTest extends WebTestCase
{
    /**
     * @test
     */
    public function testPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/registration');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Регистрация', $crawler->filter('.container h3')->text());
    }

    /**
     * @test
     */
    public function testForm()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/registration', [
            'registration' => [
                'email' => 'test@test.test',
                'plainPassword' => [
                    'first' => '123456',
                    'second' => '123456',
                ],
            ],
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Регистрация', $crawler->filter('.container h3')->text());
    }
}
