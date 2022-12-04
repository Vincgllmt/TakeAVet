<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function update(Animal $animal, Request $request, AnimalRepository $animalRepository): Response
    {
        $formulaire = $this->createForm(AnimalType::class, $animal);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $animalRepository->save($animal, true);

            return $this->redirectToRoute('app_contact_show', [
                'id' => $animal->getId(),
            ]);
        }

        return $this->renderForm('contact/update.twig', [
            'contact' => $animal,
            'formulaire' => $formulaire,
        ]);
    }

    #[Route('/animal/create')]
    public function create(Request $request, AnimalRepository $animalRepository): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $animalRepository->save($animal, true);

            return $this->redirectToRoute('app_animal');
        }
        return $this->renderForm('animal/create.twig', [
            'form' => $form,
        ]);

    }
    #[Route('/animal/{id}/delete')]
    public function delete(Animal $animal): Response
    {
    }
}
