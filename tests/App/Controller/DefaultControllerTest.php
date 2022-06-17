<?php

namespace Tests\App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByUsername('anonyme');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($this->user);
    }

    public function testHomepageIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLoginIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLoginCheckIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('login_check'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLogoutIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('logout'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testTaskListIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testFinishedTaskListIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('finished_task_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateTaskIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_create'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testEditTaskIsUp()
    {
        $this->urlGenerator->setContext(array());
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_edit'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testToggleTaskIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_toggle'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDeleteTaskIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_delete'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testUsersIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateUserIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testEditUserIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_edit'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
