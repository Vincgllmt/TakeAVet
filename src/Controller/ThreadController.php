<?php

namespace App\Controller;

use App\Entity\Thread;
use App\Form\ThreadFormType;
use App\Repository\ThreadMessageRepository;
use App\Repository\ThreadRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThreadController extends AbstractController
{
    #[Route('/threads', name: 'app_threads')]
    public function index(ThreadRepository $threadRepository, Request $request): Response
    {
        $page = $request->query->getInt('page');

        return $this->render('thread/index.html.twig', [
            'threads' => $threadRepository->findAllWithName($page, 15),
            'page' => $page,
        ]);
    }

    #[Route('/threads/{id}',
        name: 'app_threads_show',
        requirements: ['id' => "\d+"])]
    public function show(Thread $thread, ThreadMessageRepository $messageRepository): Response
    {
        return $this->render('thread/show.html.twig', [
            'thread' => $thread,
            'messages' => $messageRepository->findSortByVeto($thread),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/thread/create', name: 'app_threads_form')]
    public function create(Request $request, ThreadRepository $threadRepository): Response
    {
        $user = $this->getUser();

        $thread = new Thread();
        $form = $this->createForm(ThreadFormType::class, $thread);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Thread $handledThread * */
            $handledThread = $form->getData();

            if (null === $handledThread->getCreatedAt()) {
                $handledThread->setCreatedAt(new \DateTimeImmutable());
            }

            if (null === $handledThread->getAuthor()) {
                $handledThread->setAuthor($user);
            }

            $threadRepository->save($handledThread, flush: true);

            return $this->redirectToRoute('app_threads_show', [
                'id' => $handledThread->getId(),
            ]);
        }

        return $this->renderForm('thread/form_thread.html.twig', parameters: [
            'form' => $form,
        ]);
    }
}
