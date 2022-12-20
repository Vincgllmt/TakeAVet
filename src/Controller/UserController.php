<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AvatarChangeFormType;
use App\Repository\UserRepository;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    private Imagine $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/me', name: 'app_me')]
    public function index(Request $request, UserRepository $userRepository, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $avatarChangeForm = $this->createForm(AvatarChangeFormType::class);
        $avatarChangeForm->handleRequest($request);

        if ($avatarChangeForm->isSubmitted() && $avatarChangeForm->isValid()) {
            /** @var UploadedFile $avatarFile */
            $avatarFile = $avatarChangeForm->get('avatar')->getData();

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.webp';
                $realFilename = $avatarFile->getRealPath();


                // resize at fixed size of 512x512.
                $image = $this->imagine->open($realFilename)
                    ->thumbnail(new Box(512, 512), ManipulatorInterface::THUMBNAIL_OUTBOUND);

                // save the image to webp format
                $image->save($realFilename, [
                    'format' => 'webp',
                ]);

                // move the resized image to the 'avatar_directory'
                try {
                    $avatarFile->move(
                        $this->getParameter('avatar_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $user->setProfilePicPath($newFilename);
                $userRepository->save($user, true);
            }
        }

        return $this->renderForm('me/index.html.twig', [
            'avatarChangeForm' => $avatarChangeForm,
        ]);
    }
}
