<?php

namespace App\Controller;

use App\Entity\Allergie;
use App\Form\AllergieType;
use App\Repository\AllergieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/allergie')]
class AllergieController extends AbstractController
{
    #[Route('/', name: 'app_allergie_index', methods: ['GET'])]
    public function index(AllergieRepository $allergieRepository): Response
    {
        $allergies = $allergieRepository->findOneBy(array('userAllergie' => $this->getUser()),array('id' => 'ASC'));
        dd(count($allergies));
        if($this->getUser()->getAllergie() == null ){
            return $this->redirectToRoute("app_allergie_new");
            exit;
        }else{
            return $this->redirectToRoute("app_allergie_new");
            exit;
        }

        return $this->render('allergie/index.html.twig', [
            'allergies' => $allergies,
        ]);
    }

    #[Route('/new', name: 'app_allergie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AllergieRepository $allergieRepository): Response
    {
        $allergie = new Allergie();
        $form = $this->createForm(AllergieType::class, $allergie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $allergie->setUserAllergie($this->getUser());
            $allergieRepository->add($allergie, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('allergie/new.html.twig', [
            'allergie' => $allergie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_allergie_show', methods: ['GET'])]
    public function show(Allergie $allergie): Response
    {
        return $this->render('allergie/show.html.twig', [
            'allergie' => $allergie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_allergie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Allergie $allergie, AllergieRepository $allergieRepository): Response
    {
        $userAllergie = $allergie->getUserAllergie();

        //Check if user is owner of allergie
        if($userAllergie->getId() != $this->getUser()->getId()){
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            exit;
        }
        $form = $this->createForm(AllergieType::class, $allergie);
        $form->handleRequest($request);
        
        $ingredients  = $allergie->getIngredients();

        dump($ingredients);
        if ($form->isSubmitted() && $form->isValid()) {
            $allergie->setUserAllergie($this->getUser());
            $allergieRepository->add($allergie, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('allergie/edit.html.twig', [
            'allergie' => $allergie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_allergie_delete', methods: ['POST'])]
    public function delete(Request $request, Allergie $allergie, AllergieRepository $allergieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$allergie->getId(), $request->request->get('_token'))) {
            $allergieRepository->remove($allergie, true);
        }

        return $this->redirectToRoute('app_allergie_index', [], Response::HTTP_SEE_OTHER);
    }
}
