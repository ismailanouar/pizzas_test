<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {

        if ($this->getUser()) {
            if(in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
                return $this->redirectToRoute("admin_app_gestion");
                exit;
            }else{
                return $this->redirectToRoute("app_home");
                exit;
            }
        }else{
            return $this->redirectToRoute("app_login");
        }
        
    }
}
