<?php

namespace Tests\App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function testCreateTask()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login'));

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'anonyme2';
        $form['_password'] = 'test';
        $this->client->submit($form);

        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_create'));
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = "Blabla bla bla";
        $form['task[content]'] = "Blablabla bla bla";
        $this->client->submit($form);

        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert.alert-success', "La tâche a été bien été ajoutée.");
    }

    public function testTaskList()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login'));

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'anonyme2';
        $form['_password'] = 'test';
        $this->client->submit($form);

        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('homepage'));

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $this->client->click($link);
        $info = $crawler->filter('h1')->text();
        $info = trim(preg_replace('/\s\s+/', ' ', $info));
        $this->assertSame("Liste des tâches", $info);
    }
}
