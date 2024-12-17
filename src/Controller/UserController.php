<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user', name: 'user')]

class UserController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {

        $user = new User();
        $user->setEmail('fd@test.com')->setPassword($hasher->hashPassword($user,'0000'))
        ->setRoles(['ROLE_USER']); // Ajouter le rôle admin ici
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
