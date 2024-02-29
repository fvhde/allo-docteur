<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Builder\Api\ResourceCollectionBuilder;
use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cities')]
#[OA\Tag(name: 'Cities')]
final class CityController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
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
                    items: new OA\Items(ref: new Model(type: City::class, groups: ['default', 'city_list']))
                ),
            ],
            type: 'object'
        )
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'city_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(City::class)->createQueryBuilder('c'),
            $request
        );
    }
}