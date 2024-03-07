<?php

declare(strict_types=1);

namespace App\Form\Web\Type\Appointment;

use App\Entity\Appointment;
use App\Entity\Professional;
use App\Entity\Speciality;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Time;

final class CreateAppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           // ->add('beginAt', DateTimeType::class, ['required' => false])
            ->add('professional', EntityType::class, ['class' => Professional::class, 'required' => true])
            ->add('speciality', EntityType::class, [
                'class' => Speciality::class,
                'required' => true,
                'constraints' => [new NotBlank(['message' => 'Veuillez choisir une specialité'])],
            ])
            ->add('date', TextType::class, [
                'mapped' => false,
                'constraints' => [new NotBlank(['message' => 'Veuillez choisir une date']), new DateTime(['format' => 'Y-m-d\TH:i:s.u\Z'])],
                'required' => true
            ])
            ->add('time', TextType::class, [
                'mapped' => false,
                'constraints' => [new NotBlank(['message' => 'Veuillez choisir une heure']), new Time(['withSeconds' => false])],
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}