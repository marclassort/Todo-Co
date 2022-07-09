<?php

namespace Tests\App\Entity;

use App\Entity\Task;
use App\Manager\TaskManager;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    private $entityManager;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
    }

    public function getTask(): Task
    {
        $task = new Task();
        $task->setCreatedAt('2022-06-29 14:26:53');
        $task->setTitle('Tâche numéro 1');
        $task->setContent('Contenu numéro 1');
        $task->isDone(false);

        return $task;
    }

    public function assertHasErrors(Task $task, int $number = 0)
    {
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($task);
        $this->assertCount($number, $error);
    }

    public function testTaskIsCreated()
    {
        $this->assertHasErrors($this->getTask(), 0);
    }

    public function testExpectedTaskEqualsActualTask()
    {
        $task[0] = new Task();
        $task[0]->setCreatedAt('2022-06-29 14:26:53');
        $task[0]->setTitle('Tâche numéro 1');
        $task[0]->setContent('Contenu numéro 1');
        $task[0]->isDone(false);

        $expected = clone $task[0];
        $actual = $this->getTask();

        $this->assertEquals($expected, $actual);
    }

    public function testTaskIsNotCreated()
    {
        $task = $this->getTask();
        $task->toggle(null);

        $this->assertHasErrors($task, 1);
    }
}
