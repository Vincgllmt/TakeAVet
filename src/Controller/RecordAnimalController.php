<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Client;
use App\Repository\AnimalRecordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class RecordAnimalController extends AbstractController
{
    #[Route('/record/animal/{id}', name: 'app_record_animal')]
    #[ParamConverter('animal', class: Animal::class)]
    public function index(AnimalRecordRepository $animalRecordRepository, Animal $animal): Response
    {
        $user = $this->getUser();
        $isClient = false;
        $animalId = $animal->getId();
        if ($user instanceof Client) {
            $isClient = true;
            $clientId = $user->getId();
            $records = $animalRecordRepository->findByAnimal($animalId);
        }
        return $this->render('record_animal/index.html.twig', [
            'records' => $records,
            'isClient' => $isClient,
        ]);
    }
}
