<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Professional\ProfessionalSpecialityCrudController;
use App\Entity\Professional;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
            TextField::new('firstName')->setColumns(5),
            TextField::new('lastName')->setColumns(5),
            AssociationField::new('place')->setColumns(5),
            CollectionField::new('specialities')
                ->useEntryCrudForm(ProfessionalSpecialityCrudController::class)
                ->setColumns(5)
                ->setEntryIsComplex()
                ->onlyOnForms()
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
        return $filters
            ->add(TextFilter::new('firstName', 'FirstName'))
            ->add(TextFilter::new('lastName', 'LastName'));
    }
}
