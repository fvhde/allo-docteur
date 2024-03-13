<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\Appointment;
use App\Entity\Patient;
use App\Entity\Professional\ProfessionalSpeciality;
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
            $data = $request->request->all()['create_appointment'];
            [$h, $m] = explode(':', $data['time']);
            $start = (\DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['date']))->setTime((int)$h, (int)$m);

            $appointment
                ->setBeginAt($start)
                ->setEndAt($start->modify('+'.$this->em->getRepository(ProfessionalSpeciality::class)->getDuration($appointment->getProfessional(), $appointment->getSpeciality()) ?? '15'.'min'))
                ->setPlace($appointment->getProfessional()->getPlace())
                ->setPatient($user);

            $this->em->persist($appointment);
            $this->em->flush();
            // do anything else you need here, like send an email
            return $this->redirectToRoute('app_created_appointment');
        }

        foreach ($form->getErrors(true) as $error) {
            $request->getSession()->getFlashBag()->add('error', $error->getMessage());
        }

        return $this->redirectToRoute('app_show_professional', [
            'id' => $appointment->getProfessional()->getId(),
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