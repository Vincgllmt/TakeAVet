<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'app_animal')]
    public function index(AnimalRepository $animalRepository): Response
    {
        $animals = $animalRepository->findAll();
        return $this->render('animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }
    #[Route('/animal/{id}/update')]
    #[ParamConverter('animal', class: Animal::class)]
    public function update(Animal $animal, Request $request, AnimalRepository $animalRepository): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $animalRepository->save($animal, true);

            return $this->redirectToRoute('app_animal');
        }

        return $this->renderForm('animal/update.twig', [
            'animal' => $animal,
            'form' => $form,
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
    #[ParamConverter('animal', class: Animal::class)]
    public function delete(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    {
        $form = $this->createFormBuilder($animal)
            ->add('delete', SubmitType::class, ['label' => 'delete'])
            ->add('cancel', SubmitType::class, ['label' => 'cancel'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var SubmitButton $button */
            $button = $form->get('delete');
            if ($button->isClicked()) {
                $animalRepository->remove($animal, true);

                return $this->redirectToRoute('app_animal');
            }

            return $this->redirectToRoute('app_animal');
        }

        return $this->renderForm('animal/delete.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }
}
