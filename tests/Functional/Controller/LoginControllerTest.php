<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AppWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginControllerTest extends AppWebTestCase
{
    /**
     * @test
     * @dataProvider wrongDataForLogin
     */
    public function do_login_with_wrong_data(string $login, string $password)
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
        $this->assertContains('123', $crawler->filter('.container .has-error')->text());
    }

    public function wrongDataForLogin()
    {
        return [
            ['', ''],
        ];
    }
}