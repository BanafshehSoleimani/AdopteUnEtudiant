<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Domain;
use App\Entity\Company;
use App\Entity\Student;
use App\Entity\Adoption;
use App\Entity\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(AdminCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Adopteunetudiant');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Company', 'fas fa-user', Company::class);
        yield MenuItem::linkToCrud('Student', 'fas fa-user', Student::class);
        yield MenuItem::linkToCrud('Admin', 'fas fa-user', Admin::class);
        yield MenuItem::linkToCrud('Domain', 'fas fa-list', Domain::class);
        yield MenuItem::linkToCrud('Type de recherche', 'fas fa-list', SearchType::class);
        yield MenuItem::linkToCrud('Adoption', 'fas fa-list', Adoption::class);
    }
}