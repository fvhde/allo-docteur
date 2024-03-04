<?php

declare(strict_types=1);

namespace App\Controller\Admin\Professional;

use App\Entity\Professional\ProfessionalSpeciality;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfessionalSpecialityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProfessionalSpeciality::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnForm(),
            TextField::new('name')
        ];
    }
}