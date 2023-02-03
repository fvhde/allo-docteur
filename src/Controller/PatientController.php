<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\ResourceCollectionBuilder;
use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/patients')]
class PatientController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'user_detail'])]
    #[Route('/{id}', methods: ['GET'])]
    #[ParamConverter('patient', class: Patient::class)]
    public function getAction(Patient $patient): Patient
    {
        return $patient;
    }

    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'user_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(Patient::class)->createQueryBuilder('p'),
            $request
        );
    }

    #[Rest\View(statusCode: 201, serializerGroups: ['user_detail'])]
    #[Route(methods: ['POST'])]
    #[ParamConverter(
        'patient',
        options: [
            'deserializationContext' => ['groups' => ['user_create']],
            'validator' => ['groups' => ['user_create']],
        ],
        converter: 'fos_rest.request_body')
    ]
    public function postAction(
        Patient $patient,
        ConstraintViolationListInterface $validationErrors,
        UserPasswordHasherInterface $passwordHasher
    ): Patient {
        if (count($validationErrors) > 0) {
            throw new BadRequestHttpException($validationErrors->__toString());
        }

        $hashedPassword = $passwordHasher->hashPassword($patient, $patient->getPassword());
        $patient->setPassword($hashedPassword);

        $this->em->persist($patient);
        $this->em->flush();

        return $patient;
    }

    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['PATCH'])]
    #[ParamConverter('patient', class: Patient::class)]
    #[ParamConverter(
        'updated',
        options: [
            'deserializationContext' => ['groups' => ['user_update']],
            'validator' => ['groups' => ['user_update']],
        ],
        converter: 'fos_rest.request_body')
    ]
    public function patchAction(Patient $patient, Patient $updated, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new BadRequestHttpException($validationErrors->__toString());
        }

        $this->em->flush();
    }

    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteAction(Patient $patient)
    {
        $this->em->remove($patient);
        $this->em->flush();
    }
}
