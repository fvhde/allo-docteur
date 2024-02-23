<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Professional;
use App\Form\Admin\Type\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends DashboardController
{
    public function __construct(private EntityManagerInterface $em)
    {}

    #[Route('/admin/edit/{uuid}', 'app_admin_edit_profile')]
    public function show(Request $request, string $uuid): Response
    {
        $user = $this->em->getRepository(Professional::class)->find($uuid);
        $form = $this->createForm(EditProfileType::class, $user, [
                'action' => $this->generateUrl('app_admin_edit_profile', ['uuid' => $uuid])
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
        }

        return $this->render(
            'admin/user/edit.html.twig',
            ['form' => $form]
        );
    }
}