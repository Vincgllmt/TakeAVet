<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vaccine;
use App\Form\VaccineFormType;
use App\Repository\VaccineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VaccineController extends AbstractController
{

    #[Route('/vaccine/{id}',
        name: 'app_vaccine',
        requirements: ['id' => "\d+"])]
    public function index(VaccineRepository $repository, Request $request): Response
    {
        $client = $this->getUser();

        if (!$client instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        if (!$client->isClient()) {
            throw $this->createAccessDeniedException();
        }

        $createForm = $this->createForm(VaccineFormType::class);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            /** @var $vaccine Vaccine */
            $vaccine = $createForm->getData();
            $repository->save($vaccine, true);
        }

        $vaccines = $repository->findBy(['Animal' => $client]);

        return $this->renderForm('vaccines/index.html.twig', [
            'create_form' => $createForm,
            'vaccines' => $vaccines
        ]);
    }

    #[Route('/vaccine/update/{id}',
        name: 'app_vaccine_update',
        requirements: ['id' => "\d+"])]
    public function update(VaccineRepository $repository, Request $request, Vaccine $vaccine): Response
    {
        $client = $this->getUser();

        if (!$client instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        if (!$client->isClient()) {
            throw $this->createAccessDeniedException();
        }

        $updateForm = $this->createForm(VaccineFormType::class, $vaccine);
        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            /** @var $vaccine Vaccine */
            $vaccine = $updateForm->getData();

            $vaccine->setAnimal(null);
            $repository->save($vaccine, true);
        }

        return $this->renderForm('vaccine/update.html.twig', [
            'name' => $vaccine->getName(),
            'update_form' => $updateForm,
        ]);
    }

    #[Route('/vaccine/create')]
    public function create(Request $request, VaccineRepository $vaccineRepository): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createNotFoundException();
        }

        $vaccine = new Vaccine();

        $form = $this->createForm(VaccineFormType::class, $vaccine);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Vaccine $handledVaccine * */
            $handledVaccine = $form->getData();

            $handledVaccine->setAnimal(null);
            $vaccineRepository->save($handledVaccine, true);

            return $this->redirectToRoute('app_vaccine');
        }

        return $this->renderForm('vaccine/create.twig', [
            'form' => $form,
            ]);
    }

    #[Route('/vaccine/delete/{id}',
        name: 'app_vaccine_delete',
        requirements: ['id' => "\d+"])]
    public function delete(Request $request, VaccineRepository $repository, Vaccine $vaccine): Response
    {
        $client = $this->getUser();

        if ($client instanceof User) {
            if ($vaccine->getAnimal() === null) {
                $repository->remove($vaccine, true);
            }
        }

        return $this->redirectToRoute('app_vaccine');
    }

}
