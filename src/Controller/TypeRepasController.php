<?php

namespace App\Controller;

use App\Entity\TypeRepas;
use App\Form\TypeRepasType;
use App\Repository\TypeRepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/repas', name: 'repas.')]

class TypeRepasController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(TypeRepasRepository $typeRepasRepository): Response
    {
         // Récupérer les catégories et les statistiques
         $typeRepas = $typeRepasRepository->findBy([], ['typeRepas' => 'ASC']);
         $stats = $typeRepasRepository->getTypeRepasStats();
 
         return $this->render('type_repas/index.html.twig', [
             'typeRepas' => $typeRepas,
             'total' => $stats->getTotal(),
             'totalActif' => $stats->getActives(),
             'totalInactif' => $stats->getInactives(),
             'hasTypeRepas' => !empty($categories),
         ]);
    }

    #[Route('/create', name: 'create',methods:['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeRepas = new TypeRepas();
        $form = $this->createForm(TypeRepasType::class, $typeRepas);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($typeRepas);
            $entityManager->flush();
            $this->addFlash('success', sprintf('%s a été enregistré avec succès.', $typeRepas->getTypeRepas()));
            return $this->redirectToRoute('repas.index');

        }
        return $this->render('type_repas/create.html.twig', [
            'controller_name' => 'Type Repas','form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'show',methods:['GET'])]
    public function show(TypeRepasRepository $typeRepasRepository,$id): Response
    {
        $repas = $typeRepasRepository->find($id);
        if(!$repas){
            throw $this->createNotFoundException('La Type de repas demandée n\'existe pas.');
        }
        return $this->render('type_repas/show.html.twig', [
            'controller_name' => 'TypeRepasController','repas'=>$repas
        ]);
    }

    #[Route('/{id}/edit', name: 'edit',requirements:['id'=>'\d+'],methods:['GET','POST'])]
        public function edit(Request $request,EntityManagerInterface $entityManager,TypeRepas $typeRepas): Response
        {
            $form = $this->createForm(TypeRepasType::class, $typeRepas,['forms'=>false]);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) { 
                $entityManager->flush();
                $this->addFlash('success', sprintf('%s a été enregistré avec succès.', $typeRepas->getTypeRepas()));
                return $this->redirectToRoute('repas.index');
    
            }
            return $this->render('type_repas/edit.html.twig', [
                'controller_name' => 'Modifier Mise à jour','form'=>$form->createView()
            ]);
        }
    
}
