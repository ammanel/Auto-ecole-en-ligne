<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatApprenantController extends AbstractController
{
    #[Route('/stat/apprenant', name: 'app_stat_apprenant')]
    public function index(): Response
    {
        return $this->render('stat_apprenant/index.html.twig', [
            'controller_name' => 'StatApprenantController',
        ]);
    }
}
