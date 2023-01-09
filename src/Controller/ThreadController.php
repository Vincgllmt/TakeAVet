<?php

namespace App\Controller;

use App\Entity\Thread;
use App\Entity\ThreadMessage;
use App\Entity\Veto;
use App\Form\ThreadFormType;
use App\Form\ThreadReplyFormType;
use App\Repository\ThreadMessageRepository;
use App\Repository\ThreadRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThreadController extends AbstractController
{
    #[Route('/threads', name: 'app_threads')]
    public function index(ThreadRepository $threadRepository, Request $request): Response
    {
        $page = $request->query->getInt('page');
        $search = $request->query->get('search', '');

        $allPagesCount = (int) round($threadRepository->countBy([]) / 15);

        return $this->render('thread/index.html.twig', [
            'threads' => $threadRepository->findAllWithName($search, $page, 15),
            'page' => $page,
            'search' => $search,
            'pages_count' => $allPagesCount,
        ]);
    }

    #[Route('/threads/{id}',
        name: 'app_threads_show',
        requirements: ['id' => "\d+"])]
    public function show(Thread $thread, ThreadRepository $threadRepository, ThreadMessageRepository $messageRepository, Request $request): Response
    {
        $user = $this->getUser();
        $buttonsForm = $this->createFormBuilder(options: [
            'attr' => [
                'class' => 'd-flex align-items-center justify-content-end',
            ], ])
            ->add('closeOrReopen', SubmitType::class, ['attr' => ['class' => 'btn btn-'.($thread->isResolved() ? 'warning' : 'success')], 'label' => $thread->isResolved() ? 'Re-Ouvrir le Thread' : 'Fermer le Thread'])
            ->getForm();

        $buttonsForm->handleRequest($request);

        if ($buttonsForm->isSubmitted() && $buttonsForm->isValid()) {
            /* @var SubmitButton $closeOrReopenButton */
            $closeOrReopenButton = $buttonsForm->get('closeOrReopen');

            if ($closeOrReopenButton->isClicked() && ($this->isGranted('ROLE_ADMIN') || $user instanceof Veto || $thread->getAuthor() === $user)) {
                $thread->setResolved(!$thread->isResolved());
                $threadRepository->save($thread, true);

                return $this->redirectToRoute('app_threads_show', ['id' => $thread->getId()]);
            }
        }

        $reply = new ThreadMessage();

        $reply->setUser($this->getUser());
        $reply->setThread($thread);

        $replyForm = $this->createForm(ThreadReplyFormType::class, $reply);
        $replyForm->handleRequest($request);

        if ($replyForm->isSubmitted() && $replyForm->isValid()) {
            /** @var ThreadMessage $reply */
            $reply = $replyForm->getData();

            $reply->setCreatedAt(new \DateTimeImmutable());
            $messageRepository->save($reply, true);
        }

        return $this->renderForm('thread/show.html.twig', [
            'thread' => $thread,
            'messages' => $messageRepository->findSortByVeto($thread),
            'replyForm' => $replyForm,
            'is_owner' => $thread->getAuthor() === $this->getUser(),
            'buttonsForm' => $buttonsForm,
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

            $handledThread->setResolved(false);
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
