<?php

namespace App\Controller;

use App\Entity\Animal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'app_animal')]
    public function index(): Response
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }
    #[Route('/animal/{id}/update')]
    public function update(Animal $animal): Response
    {
    }
    #[Route('/animal/create')]
    public function create(): Response
    {
    }
    #[Route('/animal/{id}/delete')]
    public function delete(Animal $animal): Response
    {
    }
}
