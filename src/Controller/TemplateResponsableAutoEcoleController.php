<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateResponsableAutoEcoleController extends AbstractController
{
    #[Route('/template/responsable/auto/ecole', name: 'app_template_responsable_auto_ecole')]
    public function index(): Response
    {
        return $this->render('template_responsable_auto_ecole/index.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',
        ]);
    }
}
