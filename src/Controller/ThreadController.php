<?php

namespace App\Controller;

use App\Entity\Thread;
use App\Repository\ThreadMessageRepository;
use App\Repository\ThreadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThreadController extends AbstractController
{
    #[Route('/questions', name: 'app_questions')]
    public function index(ThreadRepository $threadRepository): Response
    {
        return $this->render('thread/index.html.twig', [
            'threads' => $threadRepository->findAllWithName(),
        ]);
    }

    #[Route('/questions/{id}',
        name: 'app_questions_show',
        requirements: ['id' => "\d+"])]
    public function show(Thread $thread, ThreadMessageRepository $messageRepository): Response
    {
        return $this->render('thread/show.html.twig', [
            'thread' => $thread,
            'messages' => $messageRepository->findSortByVeto($thread),
        ]);
    }

    #[Route('/questions_form/create', name: 'app_question_form')]
    public function create(): Response
    {
        return $this->render('thread/form_thread.html.twig');
    }
}
