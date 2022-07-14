<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Question;
use App\Repository\ApprenantRepository;
use App\Repository\CoursRepository;
use App\Repository\QuestionRepository;
use Doctrine\Persistence\ManagerRegistry;
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

    #[Route('/template/apprenant/details/{id}/cours', name: 'app_detail_cours')]
    public function detailCours(UserInterface $user,Cours $cours,CoursRepository $coursRepository): Response
    {
         $user->getUserIdentifier();
         $courspecifique=$coursRepository->find($cours);
       
            return $this->render('template_apprenant/detailCours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'cour' => $courspecifique,
            ]);
        
        
    }

    #[Route('/template/apprenant/question/{id}/cours', name: 'app_question_cours')]
    public function questionCours(UserInterface $user,Cours $cours,QuestionRepository $questionRepository,ManagerRegistry $doctrine): Response
    {
         $user->getUserIdentifier();
         $em=$doctrine->getManager();
        
        $resultQuestion= $questionRepository->findBy(["coursDedie"=>$cours->getId()]);
       
 
            return $this->render('template_apprenant/questionCours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'cour' => $cours,
                "qestion"=>$resultQuestion,
             
                
            ]);
        
        
    }
}
