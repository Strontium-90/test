<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class TaskController
{

    private Environment $twig;

    private EntityManagerInterface $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    public function list(Request $request): Response
    {
        $tasks =  $this->entityManager->getRepository(Task::class)->findBy([], [], 3);

        return new Response($this->twig->render('task/index.html.twig', ['tasks' => $tasks]));
    }
}
