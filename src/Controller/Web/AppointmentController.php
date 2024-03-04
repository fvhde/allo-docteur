<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\Appointment;
use App\Entity\Patient;
use App\Form\Web\Type\Appointment\CreateAppointmentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

final class AppointmentController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/appointments/create', name: 'app_create_appointment')]
    public function create(Request $request, #[CurrentUser] UserInterface $user): Response
    {
        $appointment = new Appointment();
        $form = $this->createForm(CreateAppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appointment->setPatient($user);

            $this->em->persist($appointment);
            $this->em->flush();
            // do anything else you need here, like send an email
            return $this->redirectToRoute('app_created_appointment');
        }

        return $this->render('web/professional/detail.html.twig', [
            'professional' => $appointment->getProfessional(),
            'form' => $form
        ]);
    }

    #[Route('/appointments/created', name: 'app_created_appointment')]
    public function confirm(#[CurrentUser] Patient $user): Response
    {
        return $this->render('web/appointment/confirm.html.twig', [
            'email' => $user->getEmail(),
        ]);
    }
}