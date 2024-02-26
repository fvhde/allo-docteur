<?php

namespace App\Form\Admin\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

class DayHoursType extends AbstractType
{
    public const DAYS = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('available', CheckboxType::class)
            ->add('from', TimeType::class, ['widget' => 'single_text'])
            ->add('to', TimeType::class, ['widget' => 'single_text'])
        ;
    }
}