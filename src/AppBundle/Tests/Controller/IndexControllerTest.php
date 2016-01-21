<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests for IndexController.
 */
class IndexControllerTest extends WebTestCase
{
    /**
     * Functional test for index action.
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->followRedirects();

        $router = $client->getContainer()->get('router');
        $crawler = $client->request('GET', $router->generate('index'));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('form#login')->count() == 1);
    }
}
