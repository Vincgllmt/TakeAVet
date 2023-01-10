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
    #[Route('/vaccine', name: 'app_vaccine')]
    public function index(VaccineRepository $repository, Request $request): Response
    {
        $client = $this->getUser();

        if (!$client instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        if (!$client->isVeto()) {
            throw $this->createAccessDeniedException();
        }

        $createForm = $this->createForm(VaccineFormType::class);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            /** @var $vaccine Vaccine */
            $vaccine = $createForm->getData();
            $repository->save($vaccine, true);
        }

        return $this->renderForm('vaccines/index.html.twig', [
            'create_form' => $createForm,
        ]);
    }
}
