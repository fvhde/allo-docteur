<?php

declare(strict_types=1);

namespace App\Controller\Admin\Professional;

use App\Entity\Professional\ProfessionalSpeciality;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProfessionalSpecialityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProfessionalSpeciality::class;
    }
}