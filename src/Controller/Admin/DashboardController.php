<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use App\Entity\Professional;
use App\Entity\Speciality;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/home.html.twig');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('admin/css/admin.css')
            ->addJsFile('admin/js/admin.js')
            ->addJsFile('admin/js/admin-charts.js')
        ;
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Tibse Admin');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {

        return UserMenu::new()
            ->setName($user->getFirstName())
            ->displayUserAvatar(false)
            ->addMenuItems([
                MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
                MenuItem::linkToCrud('Appointment', 'fa fa-list', Appointment::class),
                MenuItem::linkToCrud('Professional', 'fa fa-list', Professional::class)->setPermission('ROLE_ADMIN'),
                MenuItem::linkToCrud('Specialities', 'fa fa-stethoscope', Speciality::class)->setPermission('ROLE_ADMIN'),
                MenuItem::linkToRoute('Profile', 'fa fa-id-card', 'app_admin_edit_profile', ['uuid' => $user->getId()])
            ]);
    }
}
