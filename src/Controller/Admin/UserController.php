<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/admin/edit/{uuid}', 'app_admin_edit_profile')]
    public function show(): Response
    {
        return $this->render('admin/user/edit.html.twig');
    }
}