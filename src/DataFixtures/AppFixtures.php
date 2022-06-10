<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('anonyme');
        $user->setPassword('test');
        $user->setEmail('anonyme@test.fr');
        $user->setRoles([
            "ROLE_ADMIN",
            "ROLE_USER"
        ]);

        $manager->persist($user);

        $manager->flush();
    }
}
