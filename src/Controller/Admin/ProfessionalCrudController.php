<?php

namespace App\Controller\Admin;

use App\Entity\Professional;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class ProfessionalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Professional::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnForm(),
            TextField::new('firstName'),
            TextField::new('lastName'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(TextFilter::new('firstName', 'FirstName'));
    }
}
