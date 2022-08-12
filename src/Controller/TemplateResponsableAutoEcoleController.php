<?php

namespace App\Controller;

use App\Entity\Rapport;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class TemplateResponsableAutoEcoleController extends AbstractController
{
    #[Route('/template/responsable/auto/ecole', name: 'app_template_responsable_auto_ecole')]
    public function index(): Response
    {
        return $this->render('template_responsable_auto_ecole/index.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',
        ]);
    }

    #[Route('/template/responsable/auto/ecole/payement', name: 'app_payement_stat')]
    public function payemnt_menu(): Response
    {
        return $this->render('template_responsable_auto_ecole/payement.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',
        ]);
    }

    #[Route('/template/responsable/auto/ecole/rapport', name: 'app_rapport',methods:['POST','GET'])]
    public function raport(Request $request,ManagerRegistry $doctrine): Response
    {    
        $user = $this->getUser();
        $rapport=$request->request->get('contenu_rapport');

        $EntiteRapport=new Rapport();
        $EntiteRapport->setContenu(strval($rapport));
        $EntiteRapport->setCreateur($user);
        $EntiteRapport->setDateCrea(new \DateTime('now'));
        $EntiteRapport->setTimeCrea(new \DateTime('now'));
        $em=$doctrine->getManager();
        $em->persist($EntiteRapport);
        $em->flush();
        

        return $this->render('template_responsable_auto_ecole/rapport.html.twig', [
           
        ]);
    }
}
