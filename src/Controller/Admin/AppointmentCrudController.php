<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class AppointmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Appointment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnForm(),
            DateTimeField::new('beginAt')->setColumns(5),
            DateTimeField::new('endAt')->setColumns(5),
            AssociationField::new('place')->setColumns(5),
            AssociationField::new('professional')->setColumns(5),
            AssociationField::new('patient')->setColumns(5),
            AssociationField::new('speciality')->setColumns(5),
        ];
    }
}
