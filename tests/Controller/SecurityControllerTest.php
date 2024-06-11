<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    // Test if the login page is accessible
    public function testLoginPageIsAccessible()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();

        // Assert that the h1 element contains the text 'Se connecter'
        $this->assertSelectorTextContains('h1', 'Se connecter');
    }

    // Test login with invalid credentials
    public function testLoginWithInvalidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // Select the login form and fill it with invalid credentials
        $form = $crawler->selectButton('Se connecter')->form([
            'username' => 'invalid_username',
            'password' => 'invalid_password',
        ]);

        // Submit the form
        $client->submit($form);

        // Verify redirection to the login page
        $this->assertResponseRedirects('');

        // Follow the redirection
        $crawler = $client->followRedirect();
    }
}
