<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    // Controlleur d'édition du profil de l'utilisateur

    #[Route('/utilisateur/edition/{id}', name: 'user_edit')]
    public function edit(Users $user, Request $request, EntityManagerInterface $em): Response
    {
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $user) {
            return $this->redirectToRoute('main');
        }

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Les informations du compte ont bien été changées'
            );

            return $this->redirectToRoute('main');

        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
