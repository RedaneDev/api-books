<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('admin');
    }



    #[Route('/admin', name: 'admin')]
    public function dashboard(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(BookCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('API Books');
    }

    public function configureMenuItems(): iterable
    {
        // Ajout du menu sur Easy Admin
        yield MenuItem::section('User');
        yield MenuItem::linkToUrl('Connexion','fas fa-right-from-bracket','/login');
        yield MenuItem::linkToUrl('S\'enregister','fas fa-plus','/register');
        
        
        yield MenuItem::section('CRUD');
        yield MenuItem::linkToCrud('Books', 'fas fa-book', Book::class);
        yield MenuItem::linkToCrud('Authors', 'fas fa-user-pen', Author::class);

    }
}
