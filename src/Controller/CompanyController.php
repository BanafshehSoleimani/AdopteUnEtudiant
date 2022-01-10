<?php

namespace App\Controller;

use App\Form\CompanyProfilType;
use App\Form\Type\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CompanyController extends AbstractController
{
    
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    
    
    /**
     * 
     * @Route("company/edit", methods="GET|POST", name="company_edit_profil")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(CompanyProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

         //   $this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('user_edit');
        }

        return $this->render('account-company/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
      
       #[Route('/account/company/password', name: 'company_edit_password' )]
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
        
    
        return $this->render('account-company/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}