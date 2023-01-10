<?php

namespace App\Controller\Admin;

use App\Entity\CategoryAnimal;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryAnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryAnimal::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
