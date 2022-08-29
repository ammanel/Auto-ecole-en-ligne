<?php

namespace App\Controller;

use App\Entity\AutoEcole;
use App\Entity\Choisir;
use App\Repository\ApprenantRepository;
use App\Repository\ChoisirRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscriptions/{id}/', name: 'app_inscription_auto_ecole')]
    public function index(ApprenantRepository $ar,ManagerRegistry $doctrine,UserInterface $user,AutoEcole $autoEcole,ChoisirRepository $choisirRepository): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        $em=$doctrine->getManager();

        if (!$choisirRepository->findBy(["satut"=>1])==null) {
            $this->addFlash(type:'info',message:"Vous etes déjà inscrit dans une autre école\nAller dans le menu votre école et désinscrivez-vous d'abord");
            return $this->redirectToRoute('app_liste_Auto_Ecole');
        } else {
            $choixInscription=new Choisir();
            $choixInscription->setIdEcole($autoEcole);
            $choixInscription->setIdApprenant($connecter);
            $choixInscription->setDateInscription(new \DateTime('now'));
            $choixInscription->setSatut(true);
            $em->persist($choixInscription);
            $em->flush();

            $this->addFlash(type:'info',message:"votre Inscription est validé");
            return $this->redirectToRoute('app_liste_Auto_Ecole');
        }
        
       
    }
}
