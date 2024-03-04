<?php

namespace App\Controller\Web;

use App\Entity\Professional;
use App\Form\Web\Type\Appointment\CreateAppointmentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfessionalController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/professionals/show/{id}', name: 'app_show_professional')]
    public function show(string $id): Response
    {
        return $this->render(
            'web/professional/detail.html.twig',
            [
                'professional' => $this->em->getRepository(Professional::class)->find($id),
                'form' =>  $this->createForm(type: CreateAppointmentType::class, options: ['action' => $this->generateUrl('app_create_appointment')])->createView()
            ]
        );
    }
}