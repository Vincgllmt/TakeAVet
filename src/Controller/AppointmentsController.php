<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentsController extends AbstractController
{
    #[Route('/appointments', name: 'app_appointments')]
    public function index(): Response
    {
        return $this->render('appointments/index.html.twig', [
            'controller_name' => 'AppointmentsController',
        ]);
    }
}
