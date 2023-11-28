<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateurs', name: 'users_')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findBy([], ['firstname' =>'asc']);
        return $this->render('admin/users/index.html.twig', compact('users'));
    }
    #[Route ('/{slug}', name: 'compte')]
    public function compte(Users $user): Response
    {
        return $this->render('utilisateurs/compte.html.twig', compact('user'));
    }
}