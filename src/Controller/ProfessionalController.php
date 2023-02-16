<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\ResourceCollectionBuilder;
use App\Entity\Professional;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Paknahad\Querifier\Exception\InvalidQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/professionals')]
#[OA\Tag(name: 'Professionals')]
final class ProfessionalController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Professional id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns professional',
        content: new OA\JsonContent(ref: new Model(type: Professional::class, groups: ['default', 'user_detail', 'pro_detail']))
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['user_detail', 'pro_detail'])]
    #[Route('/{id}', methods: ['GET'])]
    #[ParamConverter('professional', class: Professional::class)]
    public function getAction(Professional $professional): Professional
    {
        return $professional;
    }

    /**
     * @throws InvalidQuery
     */
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
        description: 'Returns professionals list',
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
                    items: new OA\Items(ref: new Model(type: Professional::class, groups: ['default', 'user_list', 'pro_list']))
                ),
            ],
            type: 'object'
        )
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'user_list', 'pro_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(Professional::class)->createQueryBuilder('p'),
            $request
        );
    }

    #[OA\RequestBody(
        description: 'Professional data',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: Professional::class, groups: ['user_create', 'pro_create']))
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created professional',
        content: new OA\JsonContent(ref: new Model(type: Professional::class, groups: ['user_detail', 'pro_detail']))
    )]
    #[Rest\View(statusCode: 201, serializerGroups: ['user_detail', 'pro_detail'])]
    #[Route(methods: ['POST'])]
    #[ParamConverter(
        'professional',
        options: [
            'deserializationContext' => ['groups' => ['user_create', 'pro_create']],
            'validator' => ['groups' => ['user_create', 'pro_create']],
        ],
        converter: 'fos_rest.request_body')
    ]
    public function postAction(
        Professional $professional,
        ConstraintViolationListInterface $validationErrors,
        UserPasswordHasherInterface $passwordHasher
    ): Professional {
        if (count($validationErrors) > 0) {
            throw new BadRequestHttpException($validationErrors->__toString());
        }

        $hashedPassword = $passwordHasher->hashPassword($professional, $professional->getPassword());
        $professional->setPassword($hashedPassword);

        $this->em->persist($professional);
        $this->em->flush();

        return $professional;
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Professional id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\RequestBody(
        description: 'Professional data',
        required: true,
        content: new OA\JsonContent(ref: new Model(type: Professional::class, groups: ['user_update', 'pro_update']))
    )]
    #[OA\Response(
        response: 204,
        description: 'Professional updated'
    )]
    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['PATCH'])]
    #[ParamConverter('professional', class: Professional::class)]
    #[ParamConverter(
        'updated',
        options: [
            'deserializationContext' => ['groups' => ['user_update', 'pro_update']],
            'validator' => ['groups' => ['user_update', 'pro_update']],
        ],
        converter: 'fos_rest.request_body')
    ]
    public function patchAction(Professional $professional, Professional $updated, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new BadRequestHttpException($validationErrors->__toString());
        }

        $this->em->flush();
    }

    #[OA\Parameter(
        name: 'id',
        description: 'Professional id',
        in: 'path',
        schema: new OA\Schema(type: 'string', format: 'uuid')
    )]
    #[OA\Response(
        response: 204,
        description: 'Professional deleted'
    )]
    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteAction(Professional $professional)
    {
        $this->em->remove($professional);
        $this->em->flush();
    }
}
