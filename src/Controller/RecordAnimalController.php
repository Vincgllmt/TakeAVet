<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecordAnimalController extends AbstractController
{
    #[Route('/record/animal', name: 'app_record_animal')]
    public function index(): Response
    {
        return $this->render('record_animal/index.html.twig', [
            'controller_name' => 'RecordAnimalController',
        ]);
    }
}
