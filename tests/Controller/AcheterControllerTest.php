<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\LessonController;

class PurchaseControllerTest extends WebTestCase
{
    public function testIndex()
    {
        // Create an instance of Symfony's client to make HTTP requests
        $client = static::createClient();

        // Make a GET request to the /purchase route
        $client->request('GET', '/purchase');

        // Check if the response has a HTTP status code of 302 (redirect)
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}


