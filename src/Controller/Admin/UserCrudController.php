<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function updateEntity(EntityManagerInterface $manager, $entity): void
    {
        if ($entity instanceof Client) {
            $clearPassword = $this->getContext()->getRequest()->get('Client')['password'];

            if (!empty($clearPassword)) {
                $entity->setPassword($this->userPasswordHasher->hashPassword($entity, $clearPassword));
            }
        }
        parent::updateEntity($manager, $entity);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Client) {
            $clearPassword = $this->getContext()->getRequest()->get('Client')['password'];

            if (!empty($clearPassword)) {
                $entityInstance->setPassword($this->userPasswordHasher->hashPassword($entityInstance, $clearPassword));
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }


    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            EmailField::new('email'),
            TextField::new('password')
                ->onlyOnForms()
                ->setFormType(PasswordType::class)
                ->setRequired(false)
                ->setEmptyData('')
                ->setCustomOption('autocomplete', false),
        ];
    }
}
