<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateSuperAdminController extends AbstractController
{
    #[Route('/template/super/admin', name: 'app_template_super_admin')]
    public function index(): Response
    {
        return $this->render('template_super_admin/index.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
        ]);
    }


    #[Route('/template/super/admin/formulaire/admin', name: 'app_template_super_admin_formulaireAdmin')]
    public function formulaireAdmin(): Response
    {
        return $this->render('template_super_admin/formulaireAdmin.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
        ]);
    }

    #[Route('/template/super/admin/formulaire/auto/ecole', name: 'app_template_super_admin_formulaireAutoEcole')]
    public function formulaireAutoEcole(): Response
    {
        return $this->render('template_super_admin/formulaireAuto-ecole.html .twig', [
            'controller_name' => 'TemplateSuperAdminController',
        ]);
    }
}
