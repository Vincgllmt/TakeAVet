<?php

namespace App\Controller\Admin;

use App\Entity\Agenda;
use App\Entity\Unavailability;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class AgendaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agenda::class;
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('unavailabilities','unavailabilities')
                ->setFormType(Unavailability::class)
                ->formatValue(function (?string $value, Unavailability $entity) {
                    return $entity->getAgenda()->getUnavailabilities();
                })->hideOnForm(),
            /*
            AssociationField::new('Animal','Animal')
                ->setFormType(Animal::class)
                ->formatValue(function (?string $value, AnimalRecord $entity) {
                    return $entity->getAnimal()?->getName();
                })->hideOnForm(),
            AssociationField::new('Animal','Animal')
                ->setFormType(Animal::class)
                ->formatValue(function (?string $value, AnimalRecord $entity) {
                    return $entity->getAnimal()?->getName();
                })->hideOnForm(),
            AssociationField::new('Animal','Animal')
                ->setFormType(Animal::class)
                ->formatValue(function (?string $value, AnimalRecord $entity) {
                    return $entity->getAnimal()?->getName();
                })->hideOnForm()

        ];
    }
    */
}
