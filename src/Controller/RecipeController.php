<?php

namespace App\Controller;
use App\Entity\Recipe;
use App\Form\RecipeType; 
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecipeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'recipe.index')]
    public function index(RecipeRepository $recipeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $recipeRepository->findAll(),
            $request->query->getInt('page', 1),
            10 // nombre d’items par page
        );

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

#[Route('/recipe/create', name: 'recipe.create')]
public function create(Request $request, EntityManagerInterface $em): Response
{
    $recipe = new Recipe();
    $form = $this->createForm(RecipeType::class, $recipe);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($recipe);
        $em->flush();

        $this->addFlash('success', 'La recette a bien été créée !');

        return $this->redirectToRoute('recipe.index');
    }

    return $this->render('pages/recipe/create.html.twig', [
        'form' => $form->createView(),
    ]);
}

}