<?php

namespace Tests\App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient([], [
            'HTTP_HOST' => 'localhost:8000'
        ]);
        // $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        // $this->user = $this->userRepository->findOneByUsername('anonyme');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        // $this->client->loginUser($this->user);
    }

    public function testCreateUser()
    {
        // $this->testConnectedUser();

        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = "anonyme2";
        $form['user[password][first]'] = "test";
        $form['user[password][second]'] = "test";
        $form['user[email]'] = "test2@test.fr";
        $form['user[roles]'] = "ROLE_ADMIN";
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        // $this->assertSelectorTextContains('div.alert.alert-success', "L'utilisateur a bien été ajouté.");

        // $this->assertResponseIsSuccessful();
    }

    public function testConnectedUser()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login'));

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'nabulione';
        $form['_password'] = 'test';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
