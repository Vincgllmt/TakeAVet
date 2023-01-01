<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalRecord;
use App\Entity\Client;
use App\Form\AnimalRecordFormType;
use App\Form\AnimalType;
use App\Repository\AnimalRecordRepository;
use App\Repository\AnimalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'animal' => $animal,
            'isClient' => $isClient,
        ]);
    }
    #[Route('/animal/{id}/record/update')]
    #[ParamConverter('animal', class: Animal::class)]
    public function update(AnimalRecord $animalRecord, Request $request, AnimalRecordRepository $recordRepository): Response
    {
        $form = $this->createForm(AnimalRecordFormType::class, $animalRecord);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recordRepository->save($animalRecord, true);

            return $this->redirectToRoute('app_animal');
        }

        return $this->renderForm('animal/record/update.twig', [
            'record' => $animalRecord,
            'form' => $form,
        ]);
    }

    /**
     * @see https://symfony.com/doc/5.4/controller/upload_file.html
     */
    #[Route('/animal/create')]
    public function create(Request $request, AnimalRepository $animalRepository, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();

        if (!$user instanceof Client) {
            throw $this->createNotFoundException();
        }

        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo')->getData();

            /** @var Animal $handledAnimal * */
            $handledAnimal = $form->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('animal_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $handledAnimal->setPhotoPath($newFilename);
            }

            $handledAnimal->setClientAnimal($user);
            $animalRepository->save($handledAnimal, true);

            return $this->redirectToRoute('app_animal');
        }

        return $this->renderForm('animal/create.twig', [
            'form' => $form,
        ]);
    }
}
