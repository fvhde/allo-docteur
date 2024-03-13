<?php

declare(strict_types=1);

namespace App\Form\Web\Type;

use App\Entity\Speciality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
final class SpecialityAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Speciality::class,
            'label' => false,
            'placeholder' => 'Une specialité ?',
            'searchable_fields' => ['name'],
            'choice_label' => 'name',
            'attr' => ['style' => 'width: 200px']
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}