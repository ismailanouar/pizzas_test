<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\IngredientRepository;
use App\Repository\PizzaRepository;

class AdminController extends AbstractController
{
    #[Route('admin/dashboard', name: 'admin_app_dashboard')]
    public function dashboard(IngredientRepository $ingredientRepository, PizzaRepository $pizzaRepository): Response
    {
        $ingredients = $ingredientRepository->findAll();
        $pizzas = $pizzaRepository->findAll();

        $total_pizzas = count($pizzas);
        $total_ingredients = count($ingredients);

        return $this->render('admin/dashboard.html.twig', [
            'total_ingredients' => $total_ingredients,
            'total_pizzas'      => $total_pizzas,
        ]);
    }

    #[Route('admin/', name: 'admin_app_gestion')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

}