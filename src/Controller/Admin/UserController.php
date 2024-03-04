<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Professional;
use App\Form\Admin\Type\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends DashboardController
{
    public function __construct(private EntityManagerInterface $em, #[Autowire('%kernel.project_dir%/public/images/avatar')] private string $dir)
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
            $uploadedFile = $form->get('avatar')->getData();
            if ($uploadedFile) {
                $newFileName = $this->upload($uuid, $uploadedFile);
                $user->setAvatar($newFileName);
            }
            $this->em->flush();
            $this->addFlash('success', 'Profil mis à jour');
        }

        return $this->render(
            'admin/user/edit.html.twig',
            ['form' => $form]
        );
    }

    private function upload(string $id, UploadedFile $file): string
    {
        $newFileName = $id. '.' . $file->guessExtension();
        $file->move($this->dir, $newFileName);

        return $newFileName;
    }
}