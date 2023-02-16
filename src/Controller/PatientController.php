<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\ResourceCollectionBuilder;
use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/patients')]
#[OA\Tag(name: 'Patients')]
class PatientController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Patient id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns patient',
        content: new OA\JsonContent(ref: new Model(type: Patient::class, groups: ['default', 'user_detail']))
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'user_detail'])]
    #[Route('/{id}', methods: ['GET'])]
    #[ParamConverter('patient', class: Patient::class)]
    public function getAction(Patient $patient): Patient
    {
        return $patient;
    }

    #[OA\Parameter(
        name: 'page',
        description: 'The page number',
        in: 'query',
        schema: new OA\Schema(type: 'int', default: 1)
    )]
    #[OA\Parameter(
        name: 'limit',
        description: 'The number of items per page',
        in: 'query',
        schema: new OA\Schema(type: 'int', default: 10)
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns patients list',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'page', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'limit', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'total', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'next', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'prev', ref: '#/components/schemas/Integer'),
                new OA\Property(
                    property: 'items',
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Patient::class, groups: ['default', 'user_list']))
                ),
            ],
            type: 'object'
        )
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'user_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(Patient::class)->createQueryBuilder('p'),
            $request
        );
    }

    #[OA\RequestBody(
        description: 'Patient data',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: Patient::class, groups: ['user_create']))
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created patient',
        content: new OA\JsonContent(ref: new Model(type: Patient::class, groups: ['user_detail']))
    )]
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

    #[OA\Parameter(
        name: 'id',
        description: 'Patient id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\RequestBody(
        description: 'Patient data',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: Patient::class, groups: ['user_update']))
    )]
    #[OA\Response(
        response: 204,
        description: 'Patient updated'
    )]
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

    #[OA\Parameter(
        name: 'id',
        description: 'Patient id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteAction(Patient $patient)
    {
        $this->em->remove($patient);
        $this->em->flush();
    }
}
