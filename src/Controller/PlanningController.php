<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Entity\AgendaDay;
use App\Entity\Unavailability;
use App\Entity\Vacation;
use App\Entity\Veto;
use App\Form\AgendaFormType;
use App\Form\UnavailabilityFormType;
use App\Form\VacationFormType;
use App\Repository\AgendaDayRepository;
use App\Repository\AgendaRepository;
use App\Repository\AppointmentRepository;
use App\Repository\UnavailabilityRepository;
use App\Repository\VacationRepository;
use App\Repository\VetoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function show(Agenda $agenda, AppointmentRepository $appointmentRepository, Request $request): Response
    {
        $weekOffset = $request->query->get('offset', 0);

        $allApps = $appointmentRepository->findByVetoOnWeek($agenda->getVeto(), $weekOffset);

        // date('monday this week')|format_date
        $firstDayOfWeek = (new \DateTime('monday this week'))->modify("+{$weekOffset} week");
        $lastDayOfWeek = (new \DateTime('sunday this week'))->modify("+{$weekOffset} week");

        dump($agenda);
        dump($allApps);

        return $this->render('planning/show.html.twig', [
            'agenda' => $agenda,
            'appointments' => $allApps,
            'firstDayOfWeek' => $firstDayOfWeek,
            'lastDayOfWeek' => $lastDayOfWeek,
            'weekOffset' => $weekOffset,
        ]);
    }

    #[Route('/planning/create', name: 'app_planning_create')]
    public function create(Request $request, AgendaRepository $agendaRepository, AgendaDayRepository $dayRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof Veto) {
            throw $this->createAccessDeniedException();
        }

        $agendaForm = $this->createForm(AgendaFormType::class);
        $agendaForm->handleRequest($request);

        if ($agendaForm->isSubmitted() && $agendaForm->isValid()) {
            $agenda = new Agenda();
            $agenda->setVeto($user);

            $agendaRepository->save($agenda, false);

            // check for no sunday
            $dayCount = $agendaForm->get('sunday')->getData() ? 8 : 7;
            for ($i = 1; $i < $dayCount; ++$i) {
                $day = new AgendaDay();
                $day->setAgenda($agenda);
                $day->setDay($i);
                $day->setStartHour($agendaForm->get('timeStart')->getData());
                $day->setEndHour($agendaForm->get('timeEnd')->getData());

                $dayRepository->save($day, true);
            }

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->renderForm('planning/create.html.twig', [
            'agenda_form' => $agendaForm,
        ]);
    }

    #[Route('/planning/{id}/edit',
        name: 'app_planning_edit',
        requirements: ['id' => "\d+"])]
    public function edit(Request $request, AgendaRepository $agendaRepository, Agenda $agenda, VacationRepository $vacationRepository, UnavailabilityRepository $unavailabilityRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof Veto || $agenda->getVeto() !== $user) {
            throw $this->createAccessDeniedException();
        }

        $success = false;

        $vacationAddForm = $this->createForm(VacationFormType::class);
        $vacationAddForm->handleRequest($request);

        $unavailabilityAddForm = $this->createForm(UnavailabilityFormType::class);
        $unavailabilityAddForm->handleRequest($request);

        if ($vacationAddForm->isSubmitted() && $vacationAddForm->isValid()) {
            /** @var Vacation $newVacation */
            $newVacation = $vacationAddForm->getData();
            $newVacation->setAgenda($agenda);
            $vacationRepository->save($newVacation, true);
            $success = true;
        } elseif ($unavailabilityAddForm->isSubmitted() && $unavailabilityAddForm->isValid()) {
            /** @var Unavailability $newUnavailability */
            $newUnavailability = $unavailabilityAddForm->getData();
            $newUnavailability->setAgenda($agenda);
            $unavailabilityRepository->save($newUnavailability, true);
            $success = true;
        }

        return $this->renderForm('planning/edit.html.twig', [
            'agenda' => $agenda,
            'veto' => $user,
            'vacation_add_form' => $vacationAddForm,
            'unavailability_add_form' => $unavailabilityAddForm,
            'success' => $success,
            'vacation_count' => $vacationRepository->countBy(['agenda' => $agenda]),
            'unavailability_count' => $unavailabilityAddForm->count(['agenda' => $agenda]),
        ]);
    }
}
