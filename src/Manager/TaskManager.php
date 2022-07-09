<?php

namespace App\Manager;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskManager
{
    private $em;
    private $taskRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->taskRepository = $this->em->getRepository(Task::class);
    }

    public function getTasks()
    {
        return $this->taskRepository->findAll();
    }
}
