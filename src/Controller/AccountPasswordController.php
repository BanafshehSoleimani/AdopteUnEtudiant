<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
    
    #[Route('/account/password', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid())
            {
                $old_pwd = $form->get('old_password')->getData(); 
    
                if($userPasswordHasher->isPasswordValid($user, $old_pwd))
                {
                    $new_pwd = $form->get('new_password')->getData();
                    $password = $userPasswordHasher->hashPassword($user, $new_pwd);
                    $user->setPassword($password);
                    
                    $this->entityManager->flush();
                    $notification = "Votre mot de passe a bien été modifié.";
                }
                else
                {
                    $notification = "Votre mot de passe actuel n'est pas le bon.";
                }
            }
        
    
        return $this->render('account-student/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
   
}