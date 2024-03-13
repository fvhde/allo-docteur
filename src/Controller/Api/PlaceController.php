<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Builder\Api\ResourceCollectionBuilder;
use App\Entity\Place;
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

#[Route('/api/places')]
#[OA\Tag(name: 'Places')]
class PlaceController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Place id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns place',
        content: new OA\JsonContent(ref: new Model(type: Place::class, groups: ['default', 'place_detail']))
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'place_detail'])]
    #[Route('/{id}', methods: ['GET'])]
    #[ParamConverter('place', class: Place::class)]
    public function getAction(Place $place): Place
    {
        return $place;
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
        description: 'Returns places list',
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
                    items: new OA\Items(ref: new Model(type: Place::class, groups: ['default', 'place_list']))
                ),
            ],
            type: 'object'
        )
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'place_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(Place::class)->createQueryBuilder('p'),
            $request
        );
    }

    #[OA\RequestBody(
        description: 'Professional data',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: Place::class, groups: ['place_create']))
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created professional',
        content: new OA\JsonContent(ref: new Model(type: Place::class, groups: ['default', 'place_detail']))
    )]
    #[Rest\View(statusCode: 201, serializerGroups: ['place_detail'])]
    #[Route(methods: ['POST'])]
    #[ParamConverter(
        'place',
        options: [
            'deserializationContext' => ['groups' => ['place_create']],
            'validator' => ['groups' => ['place_create']],
        ],
        converter: 'fos_rest.request_body')
    ]
    public function postAction(
        Place $place,
        ConstraintViolationListInterface $validationErrors
    ): Place {
        if (count($validationErrors) > 0) {
            throw new BadRequestHttpException($validationErrors->__toString());
        }

        $this->em->persist($place);
        $this->em->flush();

        return $place;
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Place id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\RequestBody(
        description: 'Professional data',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: Place::class, groups: ['place_update']))
    )]
    #[OA\Response(
        response: 204,
        description: 'Returns nothing'
    )]
    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['PATCH'])]
    #[ParamConverter('place', class: Place::class)]
    #[ParamConverter(
        'updated',
        options: [
            'deserializationContext' => ['groups' => ['place_update']],
            'validator' => ['groups' => ['place_update']],
        ],
        converter: 'fos_rest.request_body')
    ]
    public function patchAction(Place $place, Place $updated, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new BadRequestHttpException($validationErrors->__toString());
        }

        $this->em->flush();
    }
}
