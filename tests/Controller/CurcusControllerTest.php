<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User; 
use App\Entity\Cursus;
use App\Entity\Theme;
use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface; 
use Stripe\Charge;
use App\Controller\CurcusController;
use Symfony\Component\HttpFoundation\Request;

class CurcusControllerTest extends WebTestCase
{
    public function testIndex()
    {
        // Create an instance of Symfony's client to make HTTP requests
        $client = static::createClient();

        // Make a GET request to the /curcus route
        $client->request('GET', '/curcus');

        // Check if the response has a HTTP status code of 302 (redirect)
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testCreateChargeSuccess()
    {
        // Create an instance of Symfony's client to make HTTP requests
        $client = static::createClient();

        // Create a user
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $user = new User();
        $user->setUsername('test_user');
        $user->setPassword('password123');
        $user->setEmail('test@example.com');
        // Set user properties if needed
        $entityManager->persist($user);
        $entityManager->flush();

        // Create a test cursus
        $cursus = new Cursus();
        $cursus->setName('Cursus Name');
        $cursus->setPrice(100); 
        $theme = new Theme();
        $theme->setImage('test.jpeg');
        $theme->setIcon('icon');
        $theme->setName('thename');
        $entityManager->persist($theme);
        // Replace 'Theme' with the name of your Theme class
        $cursus->setTheme($theme); 
        // Set cursus properties if needed
        $entityManager->persist($cursus);
        $entityManager->flush();

        // Make a POST request to the /cursus/create-charge route with valid payment data
        $client->request('POST', '/cursus/create-charge', [
            'stripeToken' => 'test_token',
            'cursus_id' => $cursus->getId()
        ]);

        // Check if the response has a HTTP status code of 302 (redirect)
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // Check if the payment has been saved in the database
        $purchase = $entityManager->getRepository(Purchase::class)->findOneBy([
            'user' => $user,
            'cursus' => $cursus,
        ]);
        $this->assertNotNull($purchase);
    }
}
