<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationControllerTest extends WebTestCase
{
    // Test the registration page
    public function testRegisterPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();

        // Assert that the h1 element contains the text "S'inscrire"
        $this->assertSelectorTextContains('h1', "S'inscrire");
    }
   
    // Test registering a user
    public function testRegisterUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        // Select the registration form and fill it with data
        $form = $crawler->selectButton('Créer un compte')->form([
            'registration_form[username]' => 'testuser',
            'registration_form[email]' => 'testuser@example.com',
            'registration_form[plainPassword]' => 'password123',
            'registration_form[confirmPassword]' => 'password123',
            'registration_form[role]' => 'ROLE_CLIENT',
        ]);

        // Submit the form
        $client->submit($form);

        // Assert that the response status code is 200 (OK)
        $this->assertResponseStatusCodeSame(200);
    }
}
