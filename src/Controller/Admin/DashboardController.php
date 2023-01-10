<?php

namespace App\Controller\Admin;

use App\Entity\Agenda;
use App\Entity\Animal;
use App\Entity\AnimalRecord;
use App\Entity\CategoryAnimal;
use App\Entity\Thread;
use App\Entity\ThreadMessage;
use App\Entity\Unavailability;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Take\'A\'Vet Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Threads');
        yield MenuItem::linkToCrud('Threads', 'fa fa-database', Thread::class);
        yield MenuItem::linkToCrud('Messages', 'fa fa-database', ThreadMessage::class);
        yield MenuItem::section('Animal');
        yield MenuItem::linkToCrud('Category', 'fa fa-database', CategoryAnimal::class);
        yield MenuItem::linkToCrud('Animal', 'fa fa-database', Animal::class);
        yield MenuItem::linkToCrud('Record', 'fa fa-database', AnimalRecord::class);
        yield MenuItem::section('Agenda');
        yield MenuItem::linkToCrud('Agenda', 'fa fa-database', Agenda::class);
        yield MenuItem::linkToCrud('Unvailbilities', 'fa fa-database', Unavailability::class);
        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('All Users', 'fa fa-database', User::class);
        yield MenuItem::section('Admin');

        yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $avatarUrl = ($user instanceof User) ? ('uploads/avatars/'.$user->getProfilePicPath()) : null;

        return parent::configureUserMenu($user)
            ->setAvatarUrl($avatarUrl)
            ->addMenuItems([
                MenuItem::linkToRoute('Mon profil', 'fa fa-id-card', 'app_me'),
            ]);
    }
}
