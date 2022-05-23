<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateApprenantController extends AbstractController
{
    #[Route('/template/apprenant', name: 'app_template_apprenant')]
    public function index(): Response
    {
        return $this->render('template_apprenant/index.html.twig', [
            'controller_name' => 'TemplateApprenantController',
        ]);
    }
}
