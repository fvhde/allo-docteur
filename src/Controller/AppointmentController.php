<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\ResourceCollectionBuilder;
use App\Entity\Appointment;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/appointments')]
class AppointmentController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'ap_detail'])]
    #[Route('/{id}', methods: ['GET'])]
    #[ParamConverter('appointment', class: Appointment::class)]
    public function getAction(Appointment $appointment): Appointment
    {
        return $appointment;
    }

    #[Rest\View(statusCode: 200, serializerGroups: ['default', 'ap_list'])]
    #[Route(methods: ['GET'])]
    public function cGetAction(Request $request): array
    {
        return ResourceCollectionBuilder::build(
            $this->em->getRepository(Appointment::class)->createQueryBuilder('a'),
            $request
        );
    }

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

    #[Rest\View(statusCode: 204)]
    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteAction(Appointment $appointment): void
    {
        $this->em->remove($appointment);
        $this->em->flush();
    }
}
