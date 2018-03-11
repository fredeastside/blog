<?php

namespace AppBundle\Action;

use App\Tests\Functional\AppWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegistrationControllerTest extends AppWebTestCase
{
    /**
     * @test
     */
    public function check_page()
    {
        $crawler = $this->client->request('GET', $this->router->generate('registration'));
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Регистрация', $crawler->filter('.container h3')->text());
    }

    /**
     * @test
     * @dataProvider wrongData
     *
     * @param mixed $email
     * @param mixed $password
     * @param mixed $message
     */
    public function try_registration_with_wrong_data($email, $password, $message)
    {
        $crawler = $this->client->request('GET', $this->router->generate('registration'));
        $form = $crawler->selectButton('Зарегистрироваться')->form([
            'registration' => [
                'email' => $email,
                'plainPassword' => $password,
            ],
        ]);
        $crawler = $this->client->submit($form);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains($message, $crawler->filter('.container .has-error')->text());
    }

    /**
     * @test
     */
    public function check_success_registration()
    {
        $crawler = $this->client->request('GET', $this->router->generate('registration'));
        $form = $crawler->selectButton('Зарегистрироваться')->form([
            'registration' => [
                'email' => 'test@test.test',
                'plainPassword' => [
                    'first' => '123456',
                    'second' => '123456',
                ],
            ],
        ]);
        $crawler = $this->client->submit($form);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('На вашу почту отправлено письмо для активации аккаунта.', $crawler->filter('.container .main-content')->text());
    }

    /**
     * @return array
     */
    public function wrongData()
    {
        return [
            [
                '',
                [],
                'Значение не должно быть пустым.',
            ],
            [
                '123',
                [],
                'Значение адреса электронной почты недопустимо.',
            ],
            [
                'test@test.test',
                [
                    'first' => '',
                ],
                'Значение не должно быть пустым.',
            ],
            [
                'test@test.test',
                [
                    'first' => '',
                    'second' => '',
                ],
                'Значение не должно быть пустым.',
            ],
            [
                'test@test.test',
                [
                    'first' => '123',
                    'second' => '456',
                ],
                'Значение недопустимо',
            ],
            [
                'test',
                [
                    'first' => '123',
                    'second' => '123',
                ],
                'Значение адреса электронной почты недопустимо.',
            ],
        ];
    }
}
