<?php

declare(strict_types=1);

namespace App\Form\Web\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

final class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speciality', SpecialityAutocompleteField::class)
            ->add('city', CityAutocompleteField::class)
        ;
    }
}