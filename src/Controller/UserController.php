<?php

namespace App\Controller;

use App\Form\AvatarChangeFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/me', name: 'app_me')]
    public function index(): Response
    {
        $avatarChangeForm = $this->createForm(AvatarChangeFormType::class);

        return $this->renderForm('me/index.html.twig', [
            'avatarChangeForm' => $avatarChangeForm,
        ]);
    }
}
