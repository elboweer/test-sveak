<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/users/list');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Список');
    }

    public function testRegistration(): void
    {
        $client = static::createClient();
        $client->request('GET', '/users/register');

        $form['user_register[name]'] = 'Test 1';
        $form['user_register[phone]'] = '79999999';
        $form['user_register[email]'] = 'test@test.com';
        $form['user_register[education]'] = 'special';
        $form['user_register[agreedToPersonalDataCollect]'] = '1';

        $client->submitForm('user_register_submit', $form);
        $client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}