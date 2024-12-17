<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Entity\User;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/recettes', name: 'recettes.')]
class RecetteController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(RecetteRepository $recetteRepository): Response
    {

        $recettes = $recetteRepository->findBy([], ['titreRecettes' => 'ASC']);
        $stats = $recetteRepository->getRecetteStats();

        return $this->render('recette/index.html.twig', [
            'total' => $stats->getTotal(),
             'totalActif' => $stats->getActives(),
             'totalInactif' => $stats->getInactives(),
             'hasRecettes' => !empty($recettes),
            'controller_name' => 'List de difficultés',
            'recettes'=>$recettes
        ]);    
       
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette, ['forms' => true]);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Associer l'utilisateur connecté à la recette
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $recette->setUsers($user);
    
            $recette->setDateRecettes(new \DateTime());
    
            $file = $form->get('photoRecettes')->getData();
            if ($file) {
                $filename = $recette->getTitreRecettes() . '.' . $file->getClientOriginalExtension();
                $file->move($this->getParameter('kernel.project_dir') . '/public/images/recettes', $filename);
                $recette->setPhotoRecettes($filename);
            }
    
            $entityManager->persist($recette);
            $entityManager->flush();
    
            $this->addFlash('success', sprintf('%s a été enregistré avec succès.', $recette->getTitreRecettes()));
            return $this->redirectToRoute('recettes.index');
        }
    
        return $this->render('recette/create.html.twig', [
            'controller_name' => 'RecetteController',
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'show',requirements:['id'=>'\d+'], methods:['GET'])]

    public function show(RecetteRepository $recetteRepository,$id):Response{


        $recette = $recetteRepository->find($id);
        return $this->render('recette/show.html.twig',['recette'=>$recette]);
    }

    #[Route('/{id}/edit', name: 'edit',requirements:['id'=>'\d+'], methods:['GET','POST'])]

    public function edit(Request $request, EntityManagerInterface $entityManager, Recette $recette):Response{

$form = $this->createForm(RecetteType::class, $recette,['forms'=>false]);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) { 
    $entityManager->flush();
    $this->addFlash('success', sprintf('%s a été enregistré avec succès.', $recette->getTitreRecettes()));
    return $this->redirectToRoute('recette.index');

}
        return $this->render('recette/edit.html.twig',['form'=>$form->createView()]);
    }

}
