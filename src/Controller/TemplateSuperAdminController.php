<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\AutoEcole;
use App\Entity\Message;
use App\Entity\Transaction;
use App\Form\AdminType;
use App\Form\AutoEcoleType;
use App\Repository\AdminRepository;
use App\Repository\ApprenantRepository;
use App\Repository\AutoEcoleRepository;
use App\Repository\HoraireRepository;
use App\Repository\MessageRepository;
use App\Repository\PersonneRepository;
use App\Repository\RapportRepository;
use App\Repository\SessionRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class TemplateSuperAdminController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }
    
    #[Route('/template/super/admin', name: 'app_template_super_admin')]
    public function index(PersonneRepository $personneRepository ,TransactionRepository $transaction ,RapportRepository $rapportRepository,SessionRepository $sessionRepository): Response
    {
        return $this->render('template_super_admin/index.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
            'pr'=>count($personneRepository->findAll()),
            'tr'=>count($transaction->findAll()),
            'r'=>count($rapportRepository->findAll()),
            's'=>count($sessionRepository->findAll()),
          
        ]);
    }


    #[Route('/template/super/admin/formulaire/admin', name: 'app_template_super_admin_formulaireAdmin')]
    public function formulaireAdmin(Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordhash): Response
    {
        $admin = new Admin();
        $form =$this->createForm(AdminType::class,$admin);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   

            $conf = $_POST['Confirmation'];
            if($conf != $admin->getPassword())
            {
                return $this->render('template_super_admin/formulaireAdmin.html.twig', [
                    'erreur'=>"Les mots de passes doivent être identiques",
                    "form"=> $form->createView()
                ]);
            }
            $this->addFlash('notice','Inscription Effectuée');
            $admin->setRoles(["ROLE_SUPER_ADMIN"]);
            $admin->setSex($_POST["Sex"]);
            $admin->setStatut(true);
            $hashdePassword=$passwordhash->hashPassword($admin,$admin->getpassword());
            $admin->setpassword($hashdePassword);
            $em->persist($admin);
            $em->flush($admin);
            return $this->redirectToRoute("app_template_super_admin");
        }
        return $this->render('template_super_admin/formulaireAdmin.html.twig', [
            
            "form"=> $form->createView()
        ]);
    }

    #[Route('/template/super/admin/formulaire/auto/ecole', name: 'app_template_super_admin_formulaireAutoEcole')]
    public function formulaireAutoEcole(Request $request,AutoEcoleRepository $ar,EntityManagerInterface $em,UserPasswordHasherInterface $passwordhash): Response
    {
        $autoecole = new AutoEcole();
        $form =$this->createForm(AutoEcoleType::class,$autoecole);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hashdePassword=$passwordhash->hashPassword($autoecole,$autoecole->getpassword());
            $autoecole->setpassword($hashdePassword);
            $autoecole->setRoles(["ROLE_AutoEcole"]);
            $webpath=$this->params->get("kernel.project_dir").'/public/AdminResponsable/img/ImageAutoEcole/';
            $chemin=$webpath.$_FILES['auto_ecole']["name"]["image"];
            $destination=move_uploaded_file($_FILES['auto_ecole']['tmp_name']['image'],$chemin);
            $autoecole->setimage($_FILES['auto_ecole']['name']['image']);
            $autoecole->setHoraireDebut($_POST["HeureDebut"]);
            $autoecole->setHoraireFin($_POST["HeureFin"]);
            $autoecole->setStatut(1);
            $ar->add($autoecole);
            return $this->redirectToRoute('app_template_super_admin', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('template_super_admin/formulaireAuto-ecole.html .twig', [
            'controller_name' => 'TemplateSuperAdminController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/template/super/admin/liste_admin', name: 'app_liste_admin')]
    public function liste_admin(AdminRepository $adminRepository): Response
    {
        return $this->render('template_super_admin/listeAdmin.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
            'admins'=>$adminRepository->findAll()
        ]);
    }

    #[Route('/template/super/admin/modification/{id}', name: 'app_modif_admin')]
    public function admin_modif(UserPasswordHasherInterface $passwordhash,Request $request,ManagerRegistry $doctrine,Admin $admin): Response
    {
        
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);
        $sexe=$request->request->get('Sex');
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $hashdePassword=$passwordhash->hashPassword($admin,$admin->getpassword());
            $admin->setpassword($hashdePassword);
            $admin->setSex($sexe);
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_liste_admin');
        }
        return $this->render('template_super_admin/formulaireAdmin.html.twig', [
            'controller_name' => 'TemplateSuperAdminController','form' => $form->createView()
            
        ]);
    }

    
    #[Route('/admin/{id}/supp', name: 'supp_admin')]
    public function admin_supp(ManagerRegistry $doctrine,Admin $admin): Response
    {   
            $em=$doctrine->getManager();
            $em->remove($admin);
            $em->flush();

           return $this->redirectToRoute('app_liste_admin');  
    }

    #[Route('/apprenant/{id}/supp', name: 'supp_apprenant')]
    public function apprenant_supp(ManagerRegistry $doctrine,Apprenant $apprenant): Response
    {   
            $em=$doctrine->getManager();
            $em->remove($apprenant);
            $em->flush();

           return $this->redirectToRoute('app_liste_apprenant_part_admin');  
    }



    #[Route('/template/super/admin/liste_ecole_part/', name: 'app_liste_ecole_part_admin')]
    public function liste_Ecole_part_admin(UserInterface $userInterface,HoraireRepository $horaire,ApprenantRepository $apprenantRepository,AutoEcoleRepository $autoEcoleRepository): Response
    {
        return $this->render('template_super_admin/listeEcole.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
            'ecoles'=>$autoEcoleRepository->findAll(),
            "apprenants"=>$apprenantRepository->findAll(),
            "horaires"=>$horaire->findAll(),
            "user"=>$userInterface
        ]);
    }
    #[Route('/template/super/admin/liste_ecole_part/apprenant/messages', name: 'app_notifier_ecole')]
    public function notifierEcole(PersonneRepository $personneRepository,MessageRepository $messageRepository,UserInterface $userInterface,HoraireRepository $horaire,ApprenantRepository $apprenantRepository,AutoEcoleRepository $autoEcoleRepository): Response
    {
        $message = new Message();
            # code...
            $message->setContenu($_REQUEST["contenu"]);
            $message->setEnvoyerPar( $personneRepository->find($_REQUEST["idconnecter"]));
            $message->setRecuPar($personneRepository->find($_REQUEST["idrecupar"]));
            $message->setDateEnvoi(new \DateTime('now'));
            $message->setLu(false);
            $messageRepository->add($message,true);
        
        return $this->render('template_super_admin/listeEcole.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
            'ecoles'=>$autoEcoleRepository->findAll(),
            "apprenants"=>$apprenantRepository->findAll(),
            "horaires"=>$horaire->findAll(),
            "user"=>$userInterface
        ]);
    }
    #[Route('/template/super/admin/liste_ecole_part/ecole', name: 'idecole')]
    public function idecole(PersonneRepository $personneRepository,MessageRepository $messageRepository,UserInterface $userInterface,HoraireRepository $horaire,ApprenantRepository $apprenantRepository,AutoEcoleRepository $autoEcoleRepository): Response
    {
        $id = $_REQUEST["id"];
        $ar = array();
        $ar[0] = array("id" => $id);
        return $this->json($ar);
    }

    #[Route('/template/super/ecole/modification/{id}', name: 'app_modif_ecole')]
    public function ecole_modif(UserPasswordHasherInterface $passwordhash,Request $request,ManagerRegistry $doctrine,AutoEcole $autoEcole): Response
    {
        
        $form = $this->createForm(AutoEcoleType::class, $autoEcole);
        $form->handleRequest($request);
       
        $heureF=$request->request->get('HeureFin');
        $heureD=$request->request->get('HeureDebut');
        if ($form->isSubmitted() && $form->isValid()) { 
            $hashdePassword=$passwordhash->hashPassword($autoEcole,$autoEcole->getpassword());
            $autoEcole->setpassword($hashdePassword);
            $autoEcole->setHoraireDebut($heureD);
            $autoEcole->setHoraireFin($heureF);
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_liste_ecole_part_admin');
        }
        return $this->render('template_super_admin/formulaireAuto-ecole.html .twig', [
            'controller_name' => 'TemplateSuperAdminController','form' => $form->createView()
            
        ]);
    }

    
    #[Route('/ecole/{id}/supp', name: 'supp_ecole')]
    public function ecole_supp(ManagerRegistry $doctrine,AutoEcole $autoEcole): Response
    {   
            $em=$doctrine->getManager();
            $em->remove($autoEcole);
            $em->flush();

           return $this->redirectToRoute('app_liste_ecole_part_admin');  
    }

    #[Route('/template/super/admin/liste_apprenant_part', name: 'app_liste_apprenant_part_admin')]
    public function liste_Apprenant_part_admin(ApprenantRepository $apprenantRepository): Response
    {
        return $this->render('template_super_admin/listeApprenant.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
            'apprenants'=>$apprenantRepository->findAll()
        ]);
    }

    #[Route('/template/super/admin/val_cour_apprenant/{id}', name: 'val_cour_apprenant')]
    public function val_cour_apprenant(ManagerRegistry $doctrine,Apprenant $connecter,ApprenantRepository $apprenantRepository,): Response
    {
        $transaction=new Transaction();
        $em=$doctrine->getManager();
        
        $connecter->setCoursActive(0);
        $em->persist($connecter);
        $em->flush();

        $this->addFlash('info','Cour débloquer avec succes');
        return $this->render('template_super_admin/listeApprenant.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
            'apprenants'=>$apprenantRepository->findAll()
        ]);
    }


}
