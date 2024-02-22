<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use App\Entity\Professional;
use App\Entity\Speciality;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Appointment', 'fa fa-list', Appointment::class);
        yield MenuItem::linkToCrud('Professional', 'fa fa-list', Professional::class);
        yield MenuItem::linkToCrud('Specialities', 'fa fa-stethoscope', Speciality::class);
    }
}
