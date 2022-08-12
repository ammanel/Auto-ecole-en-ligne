<?php

namespace App\Controller;

use App\Entity\AutoEcole;
use App\Entity\Cours;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\ApprenantRepository;
use App\Repository\AutoEcoleRepository;
use App\Repository\CoursRepository;
use App\Repository\QuestionRepository;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function listeCours(ManagerRegistry $doctrine,Request $request,UserInterface $user,CoursRepository $coursRepository,ApprenantRepository $ar,TransactionRepository $transactionRepository): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        if($connecter->isCoursActive() == false)
        {
                $transaction=new Transaction();
                $form = $this->createForm(TransactionType::class, $transaction);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) { 
                    $em=$doctrine->getManager();
                    $transaction->setIdApprenant($connecter);
                    $transaction->setTypeDePayement("Cours");
                    $transaction->setCours(1);
                    $connecter->setCoursActive(1);
                    $em->persist($transaction);
                    $em->flush();
                    
                }

                return $this->render('template_apprenant/cours.html.twig', [
                    'controller_name' => 'TemplateApprenantController',
                    "user"=> $user,'cours' => $coursRepository->findAll(),'form' => $form->createView()
                ]);
               
                
        }
            
        else{

        
            return $this->render('template_apprenant/cours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'cours' => $coursRepository->findAll()
            ]);
        }
        
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

    #[Route('/template/apprenant/liste/auto/ecole', name: 'app_liste_Auto_Ecole')]
    public function listeAutoEcole(UserInterface $user,AutoEcoleRepository $autoEcoleRepository): Response
    {
        
       
         return $this->render('template_apprenant/listeAutoEcole.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,"ecoles"=>$autoEcoleRepository->findAll()
            ]);
        
        
    }

    #[Route('/template/apprenant/profile/{id}/auto/ecole', name: 'app_profil_Auto_Ecole')]
    public function profilAutoEcole(UserInterface $user,AutoEcole $autoEcole): Response
    {
        
       
         return $this->render('template_apprenant/profil_auto_ecoles.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'autoecole'=>$autoEcole
            ]);
        
        
    }


    #[Route('/template/apprenant/mon/auto/ecole', name: 'app_mon_Auto_Ecole')]
    public function monAutoEcole(UserInterface $user): Response
    {
        
       
         return $this->render('template_apprenant/monEcole.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user
            ]);
        
        
    }
}
