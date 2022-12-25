<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    #[Route('/address', name: 'app_address')]
    public function index(AddressRepository $repository): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        if (!$user->isClient()) {
            throw $this->createAccessDeniedException();
        }

        $addresses = $repository->findBy(['client' => $user]);

        return $this->render('address/index.html.twig', [
            'addresses' => $addresses,
        ]);
    }
}
