<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Entity\AgendaDay;
use App\Entity\Veto;
use App\Form\AgendaFormType;
use App\Repository\AgendaDayRepository;
use App\Repository\AgendaRepository;
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
    public function show(Agenda $agenda): Response
    {
        dump($agenda);

        return $this->render('planning/show.html.twig', [
            'agenda' => $agenda,
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
}
