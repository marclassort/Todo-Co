<?php

namespace Tests\App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient([], [
            'HTTP_HOST' => 'localhost:8000'
        ]);

        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testCreateUser()
    {
        $this->testConnectedUser();

        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = "anonyme3";
        $form['user[password][first]'] = "test";
        $form['user[password][second]'] = "test";
        $form['user[email]'] = "test3@test.fr";
        $form['user[roles]'] = "ROLE_ADMIN";
        $this->client->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $this->client->followRedirect();
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertSelectorTextContains('div.alert.alert-success', "L'utilisateur a bien été ajouté.");
    }

    public function testConnectedUser()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login'));

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'anonyme2';
        $form['_password'] = 'test';
        $this->client->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testConnectedAdmin()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login'));

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'anonyme';
        $form['_password'] = 'test';
        $this->client->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }
}
