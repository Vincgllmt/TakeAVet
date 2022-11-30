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
}
