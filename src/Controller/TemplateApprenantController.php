<?php

namespace App\Controller;

use App\Repository\ApprenantRepository;
use App\Repository\CoursRepository;
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


    
    #[Route('/template/apprenant/liste/cours', name: 'app_liste_cours')]
    public function listeCours(UserInterface $user,CoursRepository $coursRepository): Response
    {
         $user->getUserIdentifier();
       
            return $this->render('template_apprenant/cours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'cours' => $coursRepository->findAll(),
            ]);
        
        
    }

    #[Route('/template/apprenant/details/cours', name: 'app_detail_cours')]
    public function detailCours(UserInterface $user): Response
    {
         $user->getUserIdentifier();
       
            return $this->render('template_apprenant/detailCours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,
            ]);
        
        
    }

    #[Route('/template/apprenant/question/cours', name: 'app_question_cours')]
    public function questionCours(UserInterface $user): Response
    {
         $user->getUserIdentifier();
       
            return $this->render('template_apprenant/questionCours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,
            ]);
        
        
    }
}
