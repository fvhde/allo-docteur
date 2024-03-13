<?php

declare(strict_types=1);

namespace App\Form\Admin\Type;

use App\Entity\Professional;
use App\Entity\ValueObject\OpeningHour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('avatar', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide',
                    ])
                ],
            ])
            ->add('hours', CollectionType::class, [
                'entry_type' => DayHoursType::class,
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'action-save btn-primary'],
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function ($event) {
                if (7 != $event->getData()->getHours()->count()) {
                    $event->getData()->getHours()->clear();
                    foreach (OpeningHour::DAYS as $day) {
                        $event->getData()->addHour((new OpeningHour())->setDay($day));
                    }
                }
            })
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professional::class,
        ]);
    }
}