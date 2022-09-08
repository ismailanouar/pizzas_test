<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        $user = $this->getUser();
        if(in_array("ROLE_ADMIN", $user->getRoles())){
            return $this->redirectToRoute("admin_app_gestion");
            exit;
        }
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute("app_home");
    }

}
