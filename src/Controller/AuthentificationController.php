<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\AutoEcole;
use App\Form\ApprenantType;
use App\Form\AutoEcoleType;
use Goxens\Goxens;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthentificationController extends AbstractController
{
    #[Route('', name: 'app_connexion')]
    public function connexion(AuthenticationUtils $authenticationUtils): Response
    {
        $error=$authenticationUtils->getLastAuthenticationError();
        $LastUsername=$authenticationUtils->getLastUsername();

        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_template_apprenant');
        }
        if ($this->isGranted('ROLE_AutoEcole')) {
            return $this->redirectToRoute('app_template_responsable_auto_ecole');
        }
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('app_template_super_admin');
        }

        return $this->render('authentification/connexion.html.twig', [
            'controller_name' => 'AuthentificationController',
            'error'=>$error,
            'LastUsername'=>$LastUsername
        ]);
    }

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordhash, ApprenantRepository $ar): Response
    {
        $apprenant = new Apprenant();
        $form =$this->createForm(ApprenantType::class,$apprenant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   

            $conf = $_POST['confirmation'];
            if($conf != $apprenant->getPassword())
            {
                return $this->render('authentification/inscription.html.twig', [
                    'controller_name' => 'AuthentificationController',
                    'erreur'=>"Les mots de passes doivent être identiques",
                    "form"=> $form->createView()
                ]);
            }
            $this->addFlash('notice','Inscription Effectuée');
            $apprenant->setRoles(["ROLE_USER"]);
            $apprenant->setSex($_POST["sex"]);
            $hashdePassword=$passwordhash->hashPassword($apprenant,$apprenant->getpassword());
            $apprenant->setpassword($hashdePassword);
            $apprenant->setStatut(false);
            $em->persist($apprenant);
            $em->flush($apprenant);
            
            //$service = $ar->findBy(array('Nom' => $apprenant->getNom()));
            return $this->render("authentification/confirmation.html.twig",["apprenant" => $apprenant,
            "id" => $apprenant->getId() ]);
        }
        return $this->render('authentification/inscription.html.twig', [
            'controller_name' => 'AuthentificationController',
            
            "form"=> $form->createView()
        ]);
    }

    #[Route('/Deconnexion', name: 'security_logout')]
    public function SecurityLogout(RequestStack $requestStack): Response
    {
        throw new \Exception('Désolée,Déconnexion échouée');
    }

    #[Route('/{id}', name: 'Confirmation',  methods: ['GET', 'POST'])]
    public function Confirmation(Apprenant $apprenant)
    {
        $apiKey = "ROD-JZTIUBF3BO9VOO8ITNZ335D8TXIJB0FMZDH";
        $userUid = " RORJJ4";

        $moi = new Goxens($apiKey, $userUid);
        $lien = "http://192.168.1.76:8001/validation/".$apprenant->getId();
        //$lien= "test";
        $message = "Monsieur ".$apprenant->getNom()." votre compte a bien ete créer \n Il ne vous reste plus qu'a l'activer avec ce lien ".$lien;
        $sender = "AutoEcole";
        $number = $apprenant->getTelephone();
        $serve = $moi->sendSms("ROD-JZTIUBF3BO9VOO8ITNZ335D8TXIJB0FMZDH","RORJJ4",$number,"AutoEcole",$message);
        //return $this->redirectToRoute("app_connexion");
        return $this->json($serve);
    }


    #[Route('/validation/{id}', name: 'app_validation',  methods: ['GET', 'POST'])]
    public function validation(Apprenant $apprenant, ApprenantRepository $ar)
    {
        $apprenant->setStatut(true);
        $ar->add($apprenant,true);
        return $this->render('authentification/validation.html.twig',['apprenant' => $apprenant]);
    }





}
