<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PizzaRepository;

class MainController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(PizzaRepository $pizzaRepository): Response
    {
        $user = $this->getUser();
        $pizzas = $pizzaRepository->findAll();
        $total_pizzas = count($pizzas);

        if(in_array("ROLE_ADMIN", $user->getRoles())){
            return $this->redirectToRoute("admin_app_gestion");
            exit;
        }
        
        return $this->render('home/index.html.twig', [
            'pizzas' => $pizzas,
            'total_pizzas' => $total_pizzas
        ]);
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute("app_home");
    }

}
