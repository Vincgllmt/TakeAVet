<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Client;
use App\Repository\AnimalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecordAnimalController extends AbstractController
{
    #[Route('/record/animal/{id}', name: 'app_record_animal')]
    #[ParamConverter('animal', class: Animal::class)]
    public function index(Animal $animalUser, AnimalRepository $animalRepository): Response
    {
        $user = $this->getUser();
        $isClient = false;
        if ($user instanceof Client) {
            $isClient = true;
            $clientId = $user->getId();
            $id = $animalUser->getId();
            $animals = $animalRepository->findById($clientId, $id);
        }

        return $this->render('record_animal/index.html.twig', [
            'animals' => $animals,
            'isClient' => $isClient,
        ]);
    }
}
