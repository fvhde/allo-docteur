<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\ResourceCollectionBuilder;
use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/places')]
class PlaceController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'place_detail'])]
    #[Route('/{id}', methods: ['GET'])]
    #[ParamConverter('place', class: Place::class)]
    public function getAction(Place $place): Place
    {
        return $place;
    }

    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'place_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(Place::class)->createQueryBuilder('p'),
            $request
        );
    }

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
