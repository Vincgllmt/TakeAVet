<?php

namespace App\Controller\Admin;

use App\Entity\AnimalRecord;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AnimalRecordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnimalRecord::class;
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
