<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\ApprenantRepository;
use App\Repository\CoursRepository;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class IncriptionSessionController extends AbstractController
{
    #[Route('/incription/session/presentiel/{id}', name: 'app_incription_session_presentiel')]
    public function inscription_session_presentiel(ManagerRegistry $doctrine,Request $request,UserInterface $user,ApprenantRepository $ar,Session $session): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        
        
                $transaction=new Transaction();
                $form = $this->createForm(TransactionType::class, $transaction);
                $form->handleRequest($request);
                $em=$doctrine->getManager();
                $transaction->setIdApprenant($connecter);
                $transaction->setTypeDePayement("présentiel");
                $transaction->setIdSession($session);
                $em->persist($transaction);
                $em->flush();
                if ($form->isSubmitted() && $form->isValid()) { 
                   
                    $this->addFlash(type:'info',message:"votre inscription a cette session pour des cours en présentiel a été validé");
                    return $this->redirectToRoute('app_mon_Auto_Ecole');
                    
                }
                
        return $this->render('incription_session/transactionSession.html..twig', [
            'controller_name' => 'IncriptionSessionController',
            "Nom"=>$connecter->getNom(),
            "Prenom"=>$connecter->getPrenom(),
            "Mail"=>$connecter->getMail(),
            'form' => $form->createView()
        ]);
    }


    
    #[Route('/incription/session/pratique/{id}', name: 'app_incription_session_pratique')]
    public function inscription_session_pratique(ManagerRegistry $doctrine,Request $request,UserInterface $user,ApprenantRepository $ar,Session $session): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        
        
                $transaction=new Transaction();
                $em=$doctrine->getManager();
                $transaction->setIdApprenant($connecter);
                $transaction->setTypeDePayement("pratique");
                $transaction->setIdSession($session);
                $em->persist($transaction);
                $em->flush();
                $this->addFlash(type:'info',message:"votre inscription a cette session pratique a été validé");
                
                return $this->redirectToRoute('app_mon_Auto_Ecole');
    }
}
