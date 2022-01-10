<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Adoption;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdoptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }





    /**
     * @Route("/adption/student{id}", name="add_to_adoption")
     */
    public function addAdoption(Request $request, EntityManagerInterface $entityManager, Student  $student): Response
    {
        $user = $this->getUser();
        $adoption = new Adoption();
        if ($student->getAdoption() == NULL) {
            $adoption->setCompany($user);
            $adoption->addStudent($student);
            $adoption->setFirstnameStudent($student->getFirstname());
            $adoption->setPhotoStudent($student->getPhoto());
            $adoption->setIsAdopted('true');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adoption);
            $entityManager->flush();

            return $this->redirectToRoute('account_company');
        }


        return $this->render('account-company/index.html.twig');


        
    }





}