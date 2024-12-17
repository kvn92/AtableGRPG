<?php

namespace App\Controller;

use App\Entity\Difficulte;
use App\Form\DifficulteType;
use App\Repository\DifficulteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/difficultes', name: 'difficultes.')]

class DifficulteController extends AbstractController
{

    #[Route('', name: 'index', methods:['GET'])]
    public function index(DifficulteRepository $difficulteRepository): Response
    {
        $difficultes = $difficulteRepository->findBy([], ['difficultes' => 'ASC']);
        $stats = $difficulteRepository->getDifficulteStats();

        return $this->render('difficulte/index.html.twig', [
            'total' => $stats->getTotal(),
             'totalActif' => $stats->getActives(),
             'totalInactif' => $stats->getInactives(),
             'hasCategories' => !empty($categories),
            'controller_name' => 'List de difficultés',
            'difficultes'=>$difficultes
        ]);
    }

    #[Route('/create', name:'create',methods:['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $difficulte = new Difficulte();
        $form = $this->createForm(DifficulteType::class, $difficulte);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
                $entityManager->persist($difficulte);
                $entityManager->flush();
                $this->addFlash('success', sprintf('%s a été enregistré avec succès.', $difficulte->getDifficultes()));
                return $this->redirectToRoute('difficultes.index');
        }
        return $this->render('difficulte/create.html.twig', [
            'controller_name' => 'Ajouter ','form'=>$form
        ]);
    }
        #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
        public function show(DifficulteRepository $difficulteRepository, int $id): Response
        {
            // Récupérer l'objet correspondant à l'ID
            $difficulte = $difficulteRepository->find($id);
        
            // Vérifier si l'objet existe
            if (!$difficulte) {
                throw $this->createNotFoundException('La difficulté demandée n\'existe pas.');
            }
        
            // Rendre la vue avec les données de la difficulté
            return $this->render('difficulte/show.html.twig', [
                'difficulte' => $difficulte,
            ]);
        }
    
    
        #[Route('/{id}/edit', name: 'edit',requirements:['id'=>'\d+'],methods:['GET','POST'])]
        public function edit(Request $request,EntityManagerInterface $entityManager,Difficulte $difficulte): Response
        {
            $form = $this->createForm(DifficulteType::class, $difficulte,['forms'=>false]);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) { 
                $entityManager->flush();
                $this->addFlash('success', sprintf('%s a été enregistré avec succès.', $difficulte->getDifficultes()));
                return $this->redirectToRoute('difficultes.index');
    
            }
            return $this->render('difficulte/edit.html.twig', [
                'controller_name' => 'Modifier Mise à jour','form'=>$form
            ]);
        }
    

   
}
