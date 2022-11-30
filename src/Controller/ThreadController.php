<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThreadController extends AbstractController
{
    #[Route('/questions', name: 'app_questions')]
    public function index(): Response
    {
        return $this->render('thread/index.html.twig');
    }

    #[Route('/questions/{id}', name: 'app_questions_show')]
    public function show(): Response
    {
        return $this->render('thread/show.html.twig');
    }
}
