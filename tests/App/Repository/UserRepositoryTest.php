<?php

namespace Tests\App\Repository;

use App\DataFixtures\AppFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testCount()
    {
        self::ensureKernelShutdown();
        $client = $this->createClient();

        $this->databaseTool->loadFixtures([
            AppFixtures::class
        ]);

        $users = $client->getContainer()->get(UserRepository::class)->count([]);
        // $users = $em->getRepository(UserRepository::class)->findAll()->count([]);

        $this->assertEquals(1, $users);
    }
}
