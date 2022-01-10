<?php

namespace App\Controller;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    
    #[Route('/', name: 'home')]
    
    public function index(Request $request): Response
    {
        $students = $this->entityManager->getRepository(Student::class)->findAll();
        
        return $this->render('home/index.html.twig', [
            'students' => $students, 
        ]);
    }
}