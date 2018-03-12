<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AppWebTestCase;
use App\User\Registration\Command\UserRegistration;
use Symfony\Component\HttpFoundation\Response;

class LoginControllerTest extends AppWebTestCase
{
    private $fixtures;

    protected function setUp()
    {
        parent::setUp();
        $this->fixtures = $this->loadFixtures();
    }

    /**
     * @test
     * @dataProvider wrongDataForLogin
     */
    public function do_login_with_wrong_data(string $login, string $password, string $message)
    {
        $crawler = $this->client->request('GET', $this->router->generate('login'));
        $form = $crawler->selectButton('Войти')->form([
            'login' => [
                'username' => $login,
                'password' => $password,
            ],
        ]);
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertContains($message, trim($crawler->filter('.container .alert-danger')->text()));
    }

    /**
     * @test
     */
    public function do_login()
    {
        /** @var UserRegistration $user */
        $user = $this->fixtures['dto_auth_user'];
        $crawler = $this->client->request('GET', $this->router->generate('login'));
        $form = $crawler->selectButton('Войти')->form([
            'login' => [
                'username' => $user->email,
                'password' => $user->plainPassword,
            ],
        ]);
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertSame(parse_url($crawler->getUri())['path'], $this->router->generate('homepage_index'));
    }

    /**
     * @test
     */
    public function log_in()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', $this->router->generate('admin_post_list'));
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Список постов', $crawler->filter('h2')->text());
    }

    public function wrongDataForLogin()
    {
        return [
            ['', '', 'Имя пользователя не найдено.'],
            ['asa', '', 'Имя пользователя не найдено.'],
            ['', 'asa', 'Имя пользователя не найдено.'],
            ['qwerty', '123456', 'Имя пользователя не найдено.'],
            ['test@test.test', '123', 'Недействительные аутентификационные данные.'],
        ];
    }
}