<?php

namespace App\Controller;

use App\Entity\Veto;
use App\Repository\AnimalRepository;
use App\Repository\AppointmentRepository;
use App\Repository\ClientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(AppointmentRepository $appointmentRepository, AnimalRepository $animalRepository, ClientRepository $clientRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof Veto) {
            throw $this->createAccessDeniedException();
        }

        $appointments = $appointmentRepository->findAllOnDate($user, new \DateTime(), false);
        dump($appointments);
        $currentAppointment = null;
        if (count($appointments) > 0) {
            $currentAppointment = $appointments[0];
        }

        return $this->render('dashboard/index.html.twig', [
            'veto' => $user,
            'appointments' => $appointments,
            'current' => $currentAppointment,
            'current_client' => (null !== $currentAppointment)
                ? $clientRepository->findOneBy(['id' => $currentAppointment['client_id']])
                : null,
            'current_animal' => (null !== $currentAppointment)
                ? $animalRepository->findOneBy(['id' => $currentAppointment['animal_id']])
                : null,
        ]);
    }
}
