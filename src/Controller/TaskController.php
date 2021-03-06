<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em)
    {
        $user = $this->getUser();

        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $em->getRepository(Task::class)->findAll(),
                'user' => $user
            ]
        );
    }

    #[Route('/finished-tasks', name: 'finished_task_list', methods: ['GET'])]
    public function listFinishedTasks(EntityManagerInterface $em)
    {
        return $this->render('task/list.html.twig', ['tasks' => $em->getRepository(Task::class)->findByIsDone(1)]);
    }

    #[Route('/tasks/create', name: 'task_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setAuthor($this->getUser());

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/tasks/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->find($id);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($task->getAuthor() == null) {
                $user = $em->getRepository(User::class)->findByUsername('anonyme');
                $task->setAuthor($user);
            }

            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}/toggle', name: 'task_toggle', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function toggleTask($id, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->find($id);

        $task->toggle(!$task->isDone());
        $em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteTask(int $id, Task $task, EntityManagerInterface $em)
    {
        $task = $em->getRepository(Task::class)->find($id);

        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
