<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Appointment;
use App\Entity\Client;
use App\Entity\TypeAppointment;
use App\Entity\Veto;
use App\Form\AppointmentFormType;
use App\Repository\AgendaDayRepository;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentsController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/appointments', name: 'app_appointments')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user instanceof Client) {
            throw $this->createAccessDeniedException();
        }

        $appointments = $user->getAppointments();

        return $this->render('appointments/index.html.twig', [
            'appointments' => $appointments,
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/appointments/take', name: 'app_appointments_take')]
    public function take(Request $request, AppointmentRepository $appointmentRepository, AgendaDayRepository $agendaDayRepository): Response
    {
        $user = $this->getUser();

        if (!$user instanceof Client) {
            throw $this->createAccessDeniedException();
        }

        $appointmentsForm = $this->createForm(AppointmentFormType::class);

        $appointmentsForm->handleRequest($request);
        if ($appointmentsForm->isSubmitted() && $appointmentsForm->isValid()) {
            /* @var DateTimeImmutable $appointmentDate */
            $appointmentDate = $appointmentsForm->get('date')->getData();

            /* @var Veto $appointmentVeto */
            $appointmentVeto = $appointmentsForm->get('vet')->getData();
            $appointmentAgenda = $appointmentVeto->getAgenda();

            /* @var TypeAppointment $appointmentType */
            $appointmentType = $appointmentsForm->get('type')->getData();

            /* @var Address $appointmentAddress */
            $appointmentAddress = $appointmentsForm->get('address')->getData();

            /* @var bool $appointmentUrgent */
            $appointmentUrgent = $appointmentsForm->get('isUrgent')->getData();

            /* @var string $appointmentNote */
            $appointmentNote = $appointmentsForm->get('note')->getData();

            // need to be after now.
            $afterDate = $appointmentDate > new \DateTime();

            $appointmentAtDate = $appointmentRepository->getAppointmentAt($appointmentDate, $appointmentType, $user);
            $validDay = $appointmentAgenda->canTakeAt($appointmentDate, $agendaDayRepository, $appointmentType);
            $alreadyAnAppointment = null !== $appointmentAtDate;

            $isAppointmentValid = !$alreadyAnAppointment
                && $validDay
                && $afterDate;

            // add errors
            if ($alreadyAnAppointment) {
                // TODO: Show minutes
                $appointmentsForm->get('date')->addError(new FormError("Impossible de prendre un rendez-vous a cette date, il y en a déjà un de {$appointmentAtDate->getType()->getDuration()} minutes"));
            }
            if (!$validDay) {
                $appointmentsForm->get('date')->addError(new FormError("Cette journée est hors horaire pour le vétérinaire, merci de consulter le planning du {$appointmentVeto->getDisplayName()}."));
            }
            if (!$afterDate) {
                $appointmentsForm->get('date')->addError(new FormError('La date ne peut pas être antérieur à la date actuelle.'));
            }

            if ($isAppointmentValid) {
                $appointment = new Appointment();
                $appointment->setType($appointmentType);
                $appointment->setVeto($appointmentVeto);
                $appointment->setClient($user);
                $appointment->setAddress($appointmentAddress);
                $appointment->setDateApp($appointmentDate);
                $appointment->setIsCompleted(false);
                $appointment->setIsUrgent($appointmentUrgent);
                $appointment->setNote($appointmentNote);

                $appointmentRepository->save($appointment, true);

                return $this->redirectToRoute('app_appointments');
            }
        }

        return $this->renderForm('appointments/take.html.twig', [
            'appointment_form' => $appointmentsForm,
        ]);
    }
}
