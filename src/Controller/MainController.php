<?php

namespace App\Controller;

use App\Entity\Allergie;
use App\Repository\UserRepository;
use App\Repository\PizzaRepository;
use App\Repository\AllergieRepository;
use App\Repository\IngredientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/espace-client')]
class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(PizzaRepository $pizzaRepository): Response
    {
        $pizzas = $pizzaRepository->findAll();
        $total_pizzas = count($pizzas);
        
        return $this->render('home/index.html.twig', [
            'pizzas' => $pizzas,
            'total_pizzas' => $total_pizzas
        ]);
    }

    #[Route('/mes-commandes', name: 'app_panier')]
    public function panier(): Response
    {
        return $this->render('home/panier.html.twig', []);
    }

    #[Route('/mes-allergies', name: 'app_allergies', methods: ['GET','POST'])]
    public function allergies(Request $request, IngredientRepository $ingredientRepository, AllergieRepository $allergieRepository): Response
    {
        $ingredients = $ingredientRepository->findAll();

        $allergies = $this->getUser()->getAllergies();
        
        if($allergies != null){
            //edit
            $allergies = $allergies->getIngredients();
        }

        if ($request->getMethod() == Request::METHOD_POST){
            $data = $request->request->all();
            $allergie = new Allergie();

            foreach ($data['ingredient'] as $key => $value){
                if($value != null){
                    $ingredient = $ingredientRepository->find($value);
                    $allergie->addIngredient($ingredient);
                }
                
            }

            $this->getUser()->setAllergies($allergie);
            $allergieRepository->add($allergie, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('home/allergies.html.twig', [
            "ingredients"  => $ingredients,
            "allergies" => $allergies,
        ]);
    }

}
