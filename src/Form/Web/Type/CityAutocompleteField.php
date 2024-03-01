<?php

declare(strict_types=1);

namespace App\Form\Web\Type;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
final class CityAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => City::class,
            'label' => false,
            'placeholder' => 'Ou ?',
            'searchable_fields' => ['name'],
            'choice_label' => 'name',
            'attr' => ['style' => 'width: 170px']
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}