<?php

namespace App\Controller;

use App\Entity\Veto;
use App\Repository\AppointmentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof Veto) {
            throw $this->createAccessDeniedException();
        }

        $appointments = $appointmentRepository->findAllOnDate(new \DateTime(), false);
        $currentAppointment = null;
        if (count($appointments) > 0) {
            $currentAppointment = $appointments[0];
        }

        return $this->render('dashboard/index.html.twig', [
            'veto' => $user,
            'appointments' => $appointments,
            'appointment' => $currentAppointment,
        ]);
    }
}
