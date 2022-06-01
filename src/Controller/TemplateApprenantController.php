<?php

namespace App\Controller;

use App\Repository\ApprenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class TemplateApprenantController extends AbstractController
{
    #[Route('/template/apprenant', name: 'app_template_apprenant')]
    public function index(UserInterface $user, ApprenantRepository $ar): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        if($connecter->getStatut() == false)
        {
            return $this->render("authentification/NonValide.html.twig");;
        }else{
            return $this->render('template_apprenant/index.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,
            ]);
        }
        
    }
}
