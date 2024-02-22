<?php

namespace App\Controller\Admin;

use App\Entity\Professional;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SearchMode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
            AssociationField::new('place'),
            CollectionField::new('specialities')
                ->setEntryIsComplex()
                ->allowAdd()
                ->allowDelete()
                ->hideOnIndex()
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['firstName', 'lastName', 'place.name'])
            ->setAutofocusSearch()
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(TextFilter::new('firstName', 'FirstName'));
    }
}
