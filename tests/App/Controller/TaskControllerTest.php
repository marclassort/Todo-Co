<?php

namespace Tests\App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient([], [
            'HTTP_HOST' => 'localhost:8000'
        ]);
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
    }

    public function testCreateTask()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login'));

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'nabulione';
        $form['_password'] = 'test';
        $this->client->submit($form);

        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_create'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = "Blabla bla bla";
        $form['task[content]'] = "Blablabla bla bla";
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
