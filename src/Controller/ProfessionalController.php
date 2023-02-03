<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\ResourceCollectionBuilder;
use App\Entity\Professional;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Paknahad\Querifier\Exception\InvalidQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/professionals')]
final class ProfessionalController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

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
    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'user_list', 'pro_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(Professional::class)->createQueryBuilder('p'),
            $request
        );
    }

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

    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteAction(Professional $professional)
    {
        $this->em->remove($professional);
        $this->em->flush();
    }
}
