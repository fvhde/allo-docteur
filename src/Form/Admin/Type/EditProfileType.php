<?php

declare(strict_types=1);

namespace App\Form\Admin\Type;

use App\Entity\Professional;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label_attr' => ['class' => 'form-control-label'],
                'attr' => ['class' => 'form-control col-md-3']
            ])
            ->add('lastName', TextType::class, [
                'label_attr' => ['class' => 'form-control-label'],
                'attr' => ['class' => 'form-control col-md-3']
            ])
            ->add('description', TextType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => ['male' => 'male', 'female' => 'female'],
            ])
            ->add('email', EmailType::class)
            ->add('birthday', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])
        ;

        foreach (DayHoursType::DAYS as $day) {
            $builder->add($day, DayHoursType::class, ['mapped' => false]);
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professional::class,
        ]);
    }
}