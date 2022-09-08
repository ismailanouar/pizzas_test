<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('admin/dashboard', name: 'admin_app_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig', []);
    }

    #[Route('admin/', name: 'admin_app_gestion')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

}