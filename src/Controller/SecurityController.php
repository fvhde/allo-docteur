<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Professional;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/me')]
class SecurityController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Rest\View(statusCode: 200, serializerGroups: ['user_detail', 'pro_detail'])]
    #[Route('', methods: ['GET'])]
    public function getAction(): Professional|Patient
    {
        return $this->em->getRepository(User::class)->findOneBy(['id' => (string) $this->getUser()->getId()]);
    }
}
