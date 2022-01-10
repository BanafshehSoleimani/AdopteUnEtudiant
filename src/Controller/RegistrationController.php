<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Company;
use App\Entity\Student;
use App\Form\AdminType;
use App\Form\CompanyType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
     /**
     * @Route("/register/student", name="register_student" , methods = {"GET", "POST"})
     */

    public function registerStudent(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Student();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );


            $photo = $form->get('photo')->getData();
            $fichierphoto = md5(uniqid()) . '.' . $photo->guessExtension();
            $photo->move(
                $this->getParameter('photo_directory'),
                $fichierphoto
            );
            
            $user->setPhoto($fichierphoto);

            $cv = $form->get('cv')->getData();
            $fichiercv = md5(uniqid()) . '.' . $cv->guessExtension();
            $cv->move(
                $this->getParameter('cv_directory'),
                $fichiercv
            );


          
            $user->setCv($fichiercv);

            $motivation = $form->get('motivation')->getData();
            $fichiermotivation = md5(uniqid()) . '.' . $motivation->guessExtension();
            $motivation->move(
                $this->getParameter('motivation_directory'),
                $fichiermotivation
            );


            $user->setMotivation($fichiermotivation);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register_student.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


     /**
     * @Route("/register/company", name="register_company" , methods = {"GET", "POST"})
     */

    public function registerCompany(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Company();
        $form = $this->createForm(CompanyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );


            $logo = $form->get('logo')->getData();
            $fichierlogo = md5(uniqid()) . '.' . $logo->guessExtension();
            $logo->move(
                $this->getParameter('logo_directory'),
                $fichierlogo
            );


            $user->setLogo($fichierlogo);
     

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register_company.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    
    
}