<?php

namespace App\Controller;

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

    #[Route('/questions/{id}', name: 'app_questions_show')]
    public function show(): Response
    {
        return $this->render('thread/show.html.twig');
    }

    #[Route('/questions_form/create', name: 'app_question_form')]
    public function create(): Response {
        return $this->render('thread/form_thread.html.twig');
    }

}
