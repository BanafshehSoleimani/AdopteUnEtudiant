<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account/company', name: 'account_company')]
    public function indexCompany(): Response
    {
        
        return $this->render('account-company/index.html.twig');
    }
    
    #[Route('/account/student', name: 'account_student')]
    public function indexStudent(): Response
    {
        return $this->render('account-student/index.html.twig');
    }
    
    #[Route('/account/admin', name: 'admin')]
    public function indexAdmin(): Response
    {
        return $this->render('account-admin/index.html.twig');
    }


}