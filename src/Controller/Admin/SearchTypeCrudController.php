<?php

namespace App\Controller\Admin;

use App\Entity\SearchType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SearchTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SearchType::class;
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
