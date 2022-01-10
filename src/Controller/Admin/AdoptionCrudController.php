<?php

namespace App\Controller\Admin;

use App\Entity\Adoption;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdoptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adoption::class;
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
