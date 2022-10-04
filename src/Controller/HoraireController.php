<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Entity\RDV;
use App\Entity\Session;
use App\Entity\Transaction;
use App\Form\HoraireType;
use App\Form\TransactionType;
use App\Repository\ApprenantRepository;
use App\Repository\AutoEcoleRepository;
use App\Repository\ChoisirRepository;
use App\Repository\HoraireRepository;
use App\Repository\PersonneRepository;
use App\Repository\RDVRepository;
use App\Repository\SessionRepository;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/horaire')]
class HoraireController extends AbstractController
{
    #[Route('/liste_horaire', name: 'app_horaire_index', methods: ['GET'])]
    public function index(HoraireRepository $horaireRepository): Response
    {
        return $this->render('horaire/index.html.twig', [
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/planning/{id}', name: 'app_planning', methods: ['GET'])]
    public function planning(HoraireRepository $horaireRepository,Session $session): Response
    {
        return $this->render('horaire/planing.html.twig', [
            'pt' => $horaireRepository->findBySortePlanning($session,'théorique'),
            'pp' => $horaireRepository->findBySortePlanning($session,'pratique'),
        ]);
    }

    #[Route('/planning_part_apprenant/{id}', name: 'app_planning_part_apprenant', methods: ['GET'])]
    public function planning_part_apprenant(HoraireRepository $horaireRepository,Session $session): Response
    {
        return $this->render('horaire/planing_part_apprenant.html.twig', [
            'pt' => $horaireRepository->findBySortePlanning($session,'théorique'),
            'pp' => $horaireRepository->findBySortePlanning($session,'pratique'),
            'session'=>$session
        ]);
    }

    #[Route('/new/ajouter_horaire/pratique/{id}/', name: 'app_horaire_new_pratique', methods: ['GET', 'POST'])]
    public function new_pratique(Request $request, HoraireRepository $horaireRepository,Session $session): Response
    {
        $horaire = new Horaire();
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);
      

        if ($form->isSubmitted() && $form->isValid()) {
            $horaire->setSession($session);
            $horaire->setType('pratique');
            $horaireRepository->add($horaire, true);


            return $this->redirectToRoute('app_horaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('horaire/new.html.twig', [
            'horaire' => $horaire,
            'form' => $form,
          
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/new/ajouter_horaire/theorique/{id}/', name: 'app_horaire_new_theorique', methods: ['GET', 'POST'])]
    public function new_theorique(Request $request, HoraireRepository $horaireRepository,Session $session): Response
    {
        $horaire = new Horaire();
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);
      

        if ($form->isSubmitted() && $form->isValid()) {
            $horaire->setSession($session);
            $horaire->setType('théorique');
            $horaireRepository->add($horaire, true);


            return $this->redirectToRoute('app_horaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('horaire/new2.html.twig', [
            'horaire' => $horaire,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }


    #[Route('/{id}/show_horaire', name: 'app_horaire_show', methods: ['GET'])]
    public function show(Horaire $horaire): Response
    {
        return $this->render('horaire/show.html.twig', [
            'horaire' => $horaire,
        ]);
    }

    #[Route('/{id}/edit_horaire', name: 'app_horaire_edit')]
    public function edit(Request $request, Horaire $horaire, HoraireRepository $horaireRepository): Response
    {
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $horaireRepository->add($horaire, true);

            return $this->redirectToRoute('app_horaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('horaire/edit.html.twig', [
            'horaire' => $horaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_horaire_delete')]
    public function delete(ManagerRegistry $doctrine, Horaire $horaire): Response
    {
        $em=$doctrine->getManager();
        $horaire->setEnable(true);
        $em->flush();

        return $this->redirectToRoute('app_horaire_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/rdv/planifiez', name: 'app_planifiez_rdv')]
    public function planning_rdv(TransactionRepository $transactionRepository,HoraireRepository $horaireRepository,SessionRepository $sessionRepository,PersonneRepository $personneRepository,UserInterface $user,ApprenantRepository $ar,ChoisirRepository $choisirRepository): Response
    {   
      
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));    
       
        $recup_transaction_session=$transactionRepository->findsession($connecter);
        $derniere_transaction= end($recup_transaction_session);
       

        if ($derniere_transaction== null) {

            $t=new Transaction();
            return $this->render('horaire/planing_rdv.html.twig', [
              
            "dt"=>$t
            
            ]);
        }

        if ($derniere_transaction->getTypeDePayement()=="présentiel") {
            return $this->render('horaire/planing_rdv.html.twig', [
                "dt"=>$derniere_transaction,
               
           
            
            ]);
        }
       
        if ($derniere_transaction->getTypeDePayement()=="pratique") {

            $session= $derniere_transaction->getIdSession();
           
            return $this->render('horaire/planing_rdv.html.twig', [
                "dt"=>$derniere_transaction ,
                "pp"=> $horaireRepository->findBySortePlanning($session,'pratique'),
       
            
            ]);
        }
       

       

      
        
        

    }


    #[Route('/rdv/liste', name: 'app_liste_rdv')]
    public function liste_rdv(RDVRepository $rDVRepository): Response
    {   
        
       
      

        return $this->render('horaire/liste_rdv.html.twig', [
            
            "RDVS"=>$rDVRepository->findByRDV()
        
        ]);
      
        
        

    }


    #[Route('/rdv/validé/{id}', name: 'app_valide_rdv')]
    public function valider_rdv(Horaire $heure,PersonneRepository $personneRepository,AutoEcoleRepository $autoEcoleRepository,Request $request,Horaire $horaire,ApprenantRepository $ar,ManagerRegistry $doctrine,UserInterface $user,ChoisirRepository $choisirRepository): Response
    {   
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        $em=$doctrine->getManager();
        $info_inscription=$choisirRepository->findByInscription($connecter);

        $RDV=new RDV();
        $RDV->setPlaning($horaire);
        $RDV->setChoix($info_inscription);
        $RDV->setDateJour(new \DateTime('now'));
        $em->persist($RDV);
        $em->flush();


        $transaction=new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);
        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();
        $arrayautoecole = $choisirRepository->findBy(array("idApprenant" => $idConnecter,"satut"=>false));
        try {
            $autoecoleId = $arrayautoecole[0]->getIdEcole();
        } catch (\Throwable $th) {
            $autoecoleId = 0;
        }
        

        $autoecole = $autoEcoleRepository->find($autoecoleId);

        if ($form->isSubmitted() && $form->isValid()) { 
            $em=$doctrine->getManager();
            $transaction->setIdApprenant($connecter);
            $transaction->setTypeDePayement("cours conduite");

            $em->persist($transaction);
            $em->flush();
            return $this->redirectToRoute('app_liste_rdv');
            
        }

       
      
        return $this->render('template_apprenant/transaction_conduite.html.twig', [
            
            'form' => $form->createView(),
            "Nom"=> $connecter->getNom(),
            "Prenom"=>$connecter->getPrenom(),
            "Mail"=>$connecter->getMail(),
            "autoecole"=> $autoecole,
            "debut"=> $heure->getHeure(),
            "fin" => $heure->getHeureFin(),
            "date"=>$heure->getDateDebut()
        
        ]);
      
    }
}
