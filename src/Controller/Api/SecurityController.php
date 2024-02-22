<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Patient;
use App\Entity\Professional;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/me')]
#[OA\Tag(name: 'Me')]
class SecurityController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[OA\Response(
        response: 200,
        description: 'Returns the current user',
        content: new OA\JsonContent(ref: new Model(type: Patient::class, groups: ['user_detail', 'pro_detail']))
    )]
    #[Rest\View(statusCode: 200, serializerGroups: ['user_detail', 'pro_detail'])]
    #[Route('', methods: ['GET'])]
    public function getAction(): Professional|Patient
    {
        return $this->em->getRepository(User::class)->findOneBy(['id' => (string) $this->getUser()->getId()]);
    }
}
