<?php

namespace App\Controller;

use App\Entity\Apprenant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WebsiteController extends AbstractController
{
    #[Route('', name: 'app_website')]
    public function index(): Response
    {  
        return $this->render('website/index.html.twig', [
            'controller_name' => 'WebsiteController',
            
        ]);
    }

    #[Route('/apropos', name: 'app_apropos')]
    public function apropos(): Response
    {  
        $apprenant=new Apprenant();
        return $this->render('website/apropos.html.twig', [
            'controller_name' => 'WebsiteController',"apprenant"=>$apprenant
            
        ]);
    }


   
}
