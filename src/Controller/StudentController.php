<?php

namespace App\Controller;

use FilterType;

use App\Classe\Filter;
use App\Entity\Student;
use App\Form\StudentCvType;
use App\Form\AdminProfilType;
use App\Form\StudentProfilType;
use App\Form\ChangePasswordType;
use App\Form\StudentDateTypeType;
use App\Form\StudentMotivationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class StudentController extends AbstractController 
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/nos-etudiants", name="students")
     */
    public function index(Request $request): Response
    {
        $filter = new Filter();
        $form = $this->createForm(FilterType::class, $filter);
        $studentInformatique = $this->entityManager->getRepository(Student::class)->findWithFilterInformatique($filter);
        $studentCommerce = $this->entityManager->getRepository(Student::class)->findWithFilterCommerce($filter);
        $studentInformation = $this->entityManager->getRepository(Student::class)->findWithFilterInformation($filter);
        $studentSante= $this->entityManager->getRepository(Student::class)->findWithFilterSante($filter);
        $studentIndustrie = $this->entityManager->getRepository(Student::class)->findWithFilterIndustrie($filter);
        $studentBanqueEtAssurances = $this->entityManager->getRepository(Student::class)->findWithFilterBanqueEtAssurances($filter);

        $form->handleRequest($request); // écoute si le formulaire est envoyé

        if ($form->isSubmitted() && $form->isValid()) {
            $students = $this->entityManager->getRepository(Student::class)->findWithFilter($filter);
            //dd($students);
        } else {
            $students = $this->entityManager->getRepository(Student::class)->findAll();
            //dd($students);

        }

        return $this->render('student/index.html.twig', [
            'students' => $students,
            'studentsInformatique' => $studentInformatique ,
            'studentsCommerce' => $studentCommerce ,
            'studentsInformation' => $studentInformation ,
            'studentsSante' => $studentSante ,
            'studentsIndustrie' => $studentIndustrie ,
            'studentsBanqueEtAssurances' => $studentBanqueEtAssurances ,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/student/{firstname}", name="student")
     */
    public function show($firstname): Response
    {
        $student = $this->entityManager->getRepository(Student::class)->findOneByFirstname($firstname);
        if (!$student) {
            return $this->redirectToRoute('students');
        } else {

            return $this->render('student/show.html.twig', [
                'student' => $student,


            ]);
        }
    }


    
    /**
     * @Route("/etudiants/informatique", name="students-informatique")
     */
    public function showInformatique(Request $request): Response
    {
        $filter = new Filter();

        $students = $this->entityManager->getRepository(Student::class)->findWithFilterInformatique($filter);

        return $this->render('student/index-informatique.html.twig', [
            'students' => $students
        ]);
    }

    /**
     * @Route("/etudiants/commerce", name="students-commerce")
     */
    public function showCommerce(Request $request): Response
    {
        $filter = new Filter();

        $students = $this->entityManager->getRepository(Student::class)->findWithFiltercommerce($filter);

        return $this->render('student/index-commerce.html.twig', [
            'students' => $students
        ]);
    }


    /**
     * @Route("/etudiants/information", name="students-information")
     */
    public function showInformation(Request $request): Response
    {
        $filter = new Filter();

        $students = $this->entityManager->getRepository(Student::class)->findWithFilterInformation($filter);

        return $this->render('student/index-information.html.twig', [
            'students' => $students
        ]);
    }

    /**
     * @Route("/etudiants/santé", name="students-sante")
     */
    public function showSante(Request $request): Response
    {
        $filter = new Filter();

        $students = $this->entityManager->getRepository(Student::class)->findWithFilterSante($filter);

        return $this->render('student/index-sante.html.twig', [
            'students' => $students
        ]);
    }


    /**
     * @Route("/etudiants/Industrie", name="students-Industrie")
     */
    public function showIndustrie(Request $request): Response
    {
        $filter = new Filter();

        $students = $this->entityManager->getRepository(Student::class)->findWithFilterIndustrie($filter);

        return $this->render('student/index-industrie.html.twig', [
            'students' => $students
        ]);
    }


    /**
     * @Route("/etudiants/BanqueEtAssurances", name="students-BanqueEtAssurances")
     */
    public function showBanqueEtAssurances(Request $request): Response
    {
        $filter = new Filter();

        $students = $this->entityManager->getRepository(Student::class)->findWithFilterBanqueEtAssurances($filter);

        return $this->render('student/index-banqueEtAssurances.html.twig', [
            'students' => $students
        ]);
    }

    /**
     * 
     * @Route("/account/student/edit", methods="GET|POST", name="student_edit_profil")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(StudentProfilType::class, $user);
        $form->handleRequest($request);

        //dd($user->getPhotos());

        if ($form->isSubmitted() && $form->isValid()) {
           // $nom = $form->getName()->getData();
           // unlink($this->getParameter('photo_directory').'/'.$nom);
            
            $photo = $form->get('photo')->getData();
            $fichierphoto = md5(uniqid()) . '.' . $photo->guessExtension();
            $photo->move(
                $this->getParameter('photo_directory'),
                $fichierphoto
            );


            $user->setPhoto($fichierphoto);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //   $this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('account_student');
        }

        return $this->render('account-student/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/account/student/password', name: 'student_edit_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();

            if ($userPasswordHasher->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $userPasswordHasher->hashPassword($user, $new_pwd);
                $user->setPassword($password);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
               // $notification = "Votre mot de passe a bien été modifié.";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon.";
            }
        }


        return $this->render('account-student/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * 
     * @Route("/account/student/date/edit", methods="GET|POST", name="student_edit_date")
     */
    public function editDate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(StudentDateTypeType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            //   $this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('account_student');
        }

        return $this->render('account-student/date.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * 
     * @Route("/account/student/cv/edit", methods="GET|POST", name="student_edit_cv")
     */
    public function editCv(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(StudentCvType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cv = $form->get('cv')->getData();
            $fichiercv = md5(uniqid()) . '.' . $cv->guessExtension();
            $cv->move(
                $this->getParameter('cv_directory'),
                $fichiercv
            );


          
            $user->setCv($fichiercv);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('account_student');

          
        }
        return $this->render('account-student/cv.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * 
     * @Route("/account/student/motivation/edit", methods="GET|POST", name="student_edit_motivation")
     */
    public function editMotivation(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(StudentMotivationType::class, $user);
        $form->handleRequest($request);
      

        if ($form->isSubmitted() && $form->isValid()) {

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

          
        }
        return $this->render('account-student/motivation.html.twig', [
            'form' => $form->createView(),
           
        ]);
    }
}