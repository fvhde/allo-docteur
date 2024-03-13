<?php

namespace App\Form\Admin\Type;

use App\Entity\ValueObject\OpeningHour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayHoursType extends AbstractType
{
    public const DAYS = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('opened', CheckboxType::class)
            ->add('from_time', TimeType::class, ['widget' => 'single_text'])
            ->add('to_time', TimeType::class, ['widget' => 'single_text'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OpeningHour::class,
        ]);
    }
}