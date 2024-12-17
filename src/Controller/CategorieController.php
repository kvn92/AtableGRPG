<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/categories', name: 'categories.')]

class CategorieController extends AbstractController
{

   // Fonction pour compter les catégories inactives


    
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
         // Récupérer les catégories et les statistiques
         $categories = $categorieRepository->findBy([], ['categories' => 'ASC']);
         $stats = $categorieRepository->getCategorieStats();
 
         return $this->render('categorie/index.html.twig', [
             'categories' => $categories,
             'totalCategories' => $stats->getTotal(),
             'totalActif' => $stats->getActives(),
             'totalInactif' => $stats->getInactives(),
             'hasCategories' => !empty($categories),
         ]);
    }

    #[Route('/create', name: 'create',methods:['POST','GET'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie,['forms'=>true]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
  
                $entityManager->persist($categorie);
                $entityManager->flush();
                $this->addFlash('success', sprintf('%s a été enregistré avec succès.', $categorie->getCategories()));
            return $this->redirectToRoute('categories.index');
              

        }
        
        return $this->render('categorie/create.html.twig', [
            'controller_name' => 'Categorie','form'=>$form
        ]);
    }

    #[Route('/{id}',name:'show',requirements:['id'=>'\d+'],methods:['GET'])]

    public function show(CategorieRepository $categorieRepository, $id,):Response{
        $categorie = $categorieRepository->find($id);

       

        return $this->render('categorie/show.html.twig',['controller_name'=>'Categorie',
            'categorie'=>$categorie]);
    }

    #[Route('/{id}/edit', name: 'edit',requirements:['id'=>'\d+'],methods:['GET','POST'])]
    public function edit(Request $request,EntityManagerInterface $entityManager,Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie,['forms'=>false]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->flush();
            $this->addFlash('success', sprintf('%s a été enregistré avec succès.', $categorie->getCategories()));

            return $this->redirectToRoute('categories.index');
            
        }
        return $this->render('categorie/edit.html.twig', [
            'controller_name' => 'Modifier Mise à jour','form'=>$form
        ]);
    }
}
