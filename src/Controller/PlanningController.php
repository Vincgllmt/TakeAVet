<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Repository\VetoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function index(VetoRepository $vetoRepository): Response
    {
        $vets = $vetoRepository->findAll();
        dump($vets);
        return $this->render('planning/index.html.twig', [
            'vets' => $vets,
        ]);
    }

    #[Route('/planning/{id}/',
        name: 'app_planning_show',
        requirements: ['id' => "\d+"])]
    public function show(Agenda $agenda): Response
    {
        dump($agenda);
        return $this->render('planning/show.html.twig', [
            'agenda' => $agenda,
        ]);
    }
}
