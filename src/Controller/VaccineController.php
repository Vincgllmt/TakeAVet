<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Client;
use App\Entity\User;
use App\Form\AddressFormType;
use App\Repository\AddressRepository;
use App\Repository\VaccineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VaccineController extends AbstractController
{
    #[Route('/address', name: 'app_address')]
    public function index(VaccineRepository $repository, Request $request): Response
    {

    }
}
