<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\ResourceCollectionBuilder;
use App\Entity\Appointment;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/appointments')]
#[OA\Tag(name: 'Appointments')]
class AppointmentController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Appointment id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns appointment',
        content: new OA\JsonContent(ref: new Model(type: Appointment::class, groups: ['default', 'ap_detail']))
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'ap_detail'])]
    #[Route('/{id}', methods: ['GET'])]
    #[ParamConverter('appointment', class: Appointment::class)]
    public function getAction(Appointment $appointment): Appointment
    {
        return $appointment;
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
        description: 'Returns appointments list',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'page', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'limit', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'total', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'next', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'prev', ref: '#/components/schemas/Integer'),
                new OA\Property(property: 'items',
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Appointment::class, groups: ['default', 'ap_list']))
                )]
        )
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'ap_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(Appointment::class)->createQueryBuilder('a'),
            $request
        );
    }

    #[OA\RequestBody(
        description: 'Appointment data',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: Appointment::class, groups: ['ap_create']))
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created appointment',
        content: new OA\JsonContent(ref: new Model(type: Appointment::class, groups: ['ap_detail']))
    )]
    #[Rest\View(statusCode: 201, serializerGroups: ['ap_detail'])]
    #[Route(methods: ['POST'])]
    #[ParamConverter('appointment', options: ['deserializationContext' => ['groups' => ['ap_create']], 'validator' => ['groups' => ['ap_create']]], converter: 'fos_rest.request_body')]
    public function postAction(Appointment $appointment, ConstraintViolationListInterface $validationErrors): Appointment
    {
        if (count($validationErrors) > 0) {
            throw new BadRequestHttpException($validationErrors->__toString());
        }

        $this->em->persist($appointment);
        $this->em->flush();

        return $appointment;
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Appointment id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\RequestBody(
        description: 'Appointment data',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: Appointment::class, groups: ['ap_update']))
    )]
    #[OA\Response(
        response: 204,
        description: 'Appointment updated'
    )]
    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['PATCH'])]
    #[ParamConverter('appointment', class: Appointment::class)]
    #[ParamConverter('updated', options: ['deserializationContext' => ['groups' => ['ap_update']], 'validator' => ['groups' => ['ap_update']]], converter: 'fos_rest.request_body')]
    public function patchAction(Appointment $appointment, Appointment $updated, ConstraintViolationListInterface $validationErrors): void
    {
        if (count($validationErrors) > 0) {
            throw new BadRequestHttpException($validationErrors->__toString());
        }

        $this->em->flush();
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Appointment id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\Response(
        response: 204,
        description: 'Appointment deleted'
    )]
    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteAction(Appointment $appointment): void
    {
        $this->em->remove($appointment);
        $this->em->flush();
    }
}
