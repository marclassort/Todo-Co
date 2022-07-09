<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('anonyme');
        $user->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $user,
                'test'
            )
        );
        $user->setEmail('anonyme@test.fr');
        $user->setRoles([
            "ROLE_ADMIN",
            "ROLE_USER"
        ]);

        $manager->persist($user);

        $task = new Task();
        $task->setCreatedAt(new DateTime());
        $task->setTitle('Titre de tâche');
        $task->setContent('Contenu de tâche');
        $task->isDone(false);
        $task->setAuthor($user);

        $manager->persist($task);

        $manager->flush();
    }
}
