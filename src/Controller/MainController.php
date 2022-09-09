<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PizzaRepository;
use App\Repository\IngredientRepository;

class MainController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(PizzaRepository $pizzaRepository): Response
    {
        $pizzas = $pizzaRepository->findAll();
        $total_pizzas = count($pizzas);
        
        return $this->render('home/index.html.twig', [
            'pizzas' => $pizzas,
            'total_pizzas' => $total_pizzas
        ]);
    }

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

    #[Route('mes-commandes', name: 'app_panier')]
    public function panier(): Response
    {
        return $this->render('home/panier.html.twig', []);
    }

    #[Route('mes-allergies', name: 'app_allergies')]
    public function allergies(PizzaRepository $pizzaRepository, IngredientRepository $ingredientRepository): Response
    {
        $ingredients = $ingredientRepository->findAll();
        $pizzas = $pizzaRepository->findAll();

        return $this->render('home/allergies.html.twig', [
            "ingredients"  => $ingredients,
        ]);
    }

}
