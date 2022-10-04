<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\AutoEcole;
use App\Entity\Message;
use App\Entity\Rapport;
use App\Form\AutoEcoleModifType;
use App\Form\MessageType;
use App\Repository\AutoEcoleRepository;
use App\Repository\ChoisirRepository;
use App\Repository\MessageRepository;
use App\Repository\PersonneRepository;
use App\Repository\RapportRepository;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class TemplateResponsableAutoEcoleController extends AbstractController
{

    private $requestStack; 
    private $params;

    public function __construct(RequestStack $requestStack, ParameterBagInterface $params)
    {
        $this->requestStack = $requestStack;
        $this->params=$params;
    }

    #[Route('/template/responsable/auto/ecole', name: 'app_template_responsable_auto_ecole')]
    public function index(SessionRepository $sessionRepository,RapportRepository $rapportRepository,ChoisirRepository $choisirRepository,UserInterface $user,PersonneRepository $personneRepository,MessageRepository $messageRepository): Response
    {


        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();
        $messages = $messageRepository->find($idConnecter);
        $choix = $choisirRepository->findAll();

        $napp=count($choisirRepository->findByApprenant($idConnecter));
        $nrapp=count($rapportRepository->findBy(["createur"=>$idConnecter]));
        $nsess=count($sessionRepository->findBy(["autoEcole"=>$idConnecter]));
        return $this->render('template_responsable_auto_ecole/index.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',
            "choix"=> $choix,
            "messages"=> $messages,
            "idapprenant"=>2,
            "napp"=>$napp,
            "nra"=>$nrapp,
            "ns"=>$nsess,
            "user"=>$user


        ]);
    }

    #[Route('/template/responsable/auto/ecole/message_choix_apprenant', name: 'message_choix_apprenant')]
    public function message_choix_apprenant(ChoisirRepository $choisirRepository,UserInterface $user,PersonneRepository $personneRepository,MessageRepository $messageRepository): Response
    {
        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();
        $choix = $choisirRepository->findBy(array("idEcole"=>$idConnecter,"satut"=>true));

        return $this->render("template_responsable_auto_ecole/liste_apprenant.html.twig",
        ["apprenant" => $choix]
    );
    }


    

    #[Route('/template/responsable/auto/ecole/message_apprenant/{id}/ecole', name: 'message_apprenant', methods: ['GET', 'POST'])]
    public function message_apprenant(Apprenant $apprenant,ChoisirRepository $choisirRepository,UserInterface $user,PersonneRepository $personneRepository,MessageRepository $messageRepository): Response
    {
        
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        
        if (isset($_REQUEST['contenu']) && $_REQUEST['contenu'] != "") {
            

           
            
            # code...
            $message->setContenu($_REQUEST["contenu"]);
            $message->setEnvoyerPar( $personneRepository->find($_REQUEST["idconnecter"]));
            $message->setRecuPar($personneRepository->find($_REQUEST["idrecupar"]));
            $message->setDateEnvoi(new \DateTime('now'));
            $message->setLu(false);
            $messageRepository->add($message,true);

            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
            return $this->json($ar);

        }
        $arraypersonne = $personneRepository->findOneBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne->getId();
        $choix = $choisirRepository->findBy(array("idEcole"=>$idConnecter));
        $messages = $messageRepository->findBy(array("EnvoyerPar"=>$apprenant->getId()));
        //Creation d'une session


        return $this->render("template_responsable_auto_ecole/message.html.twig",
        ["apprenant" => $apprenant,
        "messages" => $messages,
        "user"=>$user,
        "form"=>$form->createView()
        ]
    );
    }

    #[Route('/template/responsable/auto/ecole/message_apprenant/ecole/message', name: 'message_apprenant_async')]
    public function message_async(Request $request,ChoisirRepository $choisirRepository,UserInterface $user,AutoEcoleRepository $autoEcoleRepository,PersonneRepository $personneRepository,MessageRepository $messageRepository): Response
    {   
        $arraypersonne = $personneRepository->findOneBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne->getId();
        $message = new Message();




        if ($_REQUEST["contenu"] == "uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd") {
            # code...
            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
            return $this->json($ar);
        }





        else {
            $choix = $choisirRepository->findBy(array("idApprenant"=>$idConnecter,"satut"=>true));

        $auto = new AutoEcole();
        try {
            //code...
            $auto = $autoEcoleRepository->find($choix[0]->getIdEcole());
        } catch (\Throwable $th) {
            //throw $th;
            $auto->setDescription("");
            
        }
            
            # code...
            $message->setContenu($_REQUEST["contenu"]);
            $message->setEnvoyerPar($personneRepository->find($idConnecter));
            $message->setRecuPar($personneRepository->find($auto->getId()));
            $message->setDateEnvoi(new \DateTime('now'));
            $message->setLu(false);
            $messageRepository->add($message,true);

            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
            return $this->json($ar);
        }
        
    }



    #[Route('/template/responsable/auto/ecole/payement', name: 'app_payement_stat')]
    public function payemnt_menu(): Response
    {
        return $this->render('template_responsable_auto_ecole/payement.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',
        ]);
    }

    #[Route('vue/{id}/rapport', name: 'app_rapport',methods:['POST','GET'])]
    public function raport(Request $request,ManagerRegistry $doctrine,Apprenant $apprenant): Response
    {    
        $user = $this->getUser();
        $rapport=$request->request->get('contenu_rapport');

        $EntiteRapport=new Rapport();
        if ($rapport== null || $rapport=="") {
            # code...
        } else {
            $EntiteRapport->setContenu(strval($rapport));
            $EntiteRapport->setCreateur($user);
            $EntiteRapport->setDateCrea(new \DateTime('now'));
            $EntiteRapport->setTimeCrea(new \DateTime('now'));
            $EntiteRapport->setApRapport($apprenant);
            $em=$doctrine->getManager();
            $em->persist($EntiteRapport);
            $em->flush();
            
    
        }
       
       
       
        return $this->render('template_responsable_auto_ecole/rapport.html.twig', [
           
        ]);
    }


    #[Route('/template/responsable/auto/ecole/{id}/profil', name: 'app_template_responsable_auto_ecole_profil')]
    public function profilEcole(AutoEcoleRepository $autoEcoleRepository,UserPasswordHasherInterface $passwordhash,ChoisirRepository $choisirRepository,PersonneRepository $personneRepository,UserInterface $user,Request $request,ManagerRegistry $doctrine): Response
    {
        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();

        $a = $user->getUserIdentifier();
        $connecter = $autoEcoleRepository->findOneBy(array("Telephone"=>$a));

        $res=count($choisirRepository->findByApprenant($idConnecter)) ;
        $form = $this->createForm(AutoEcoleModifType::class, $connecter);
        $form->handleRequest($request);
        

      
        if ($form->isSubmitted() && $form->isValid()) { 
            $hashdePassword=$passwordhash->hashPassword($connecter,$connecter->getpassword());
            $connecter->setpassword($hashdePassword);
            $em=$doctrine->getManager();
            $em->flush();
            
        }

        return $this->render('template_responsable_auto_ecole/profil_auto_ecole.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController','id'=>$idConnecter,
            'user'=>$user,
            'form' => $form->createView(),
            'inscrit'=>$res
        ]);
    }


   
    #[Route('liste/rapport', name: 'app_liste_rapport')]
    public function liste_rapport(RapportRepository $rapportRepository): Response
    {
        $listeRapport=$rapportRepository->findByDateRes();

        return $this->render('template_responsable_auto_ecole/liste_rapport.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',
            'listeRapport'=>$listeRapport
        ]);
    }

   

    #[Route('/template/responsable/auto/ecole/choix/ecrire/rapport', name: 'app_choix_rapport')]
    public function choixRapport(UserInterface $user,ChoisirRepository $choisirRepository, AutoEcoleRepository $autoEcoleRepository): Response
    {
        
        $a = $user->getUserIdentifier();
        $connecter = $autoEcoleRepository->findOneBy(array("Telephone"=>$a));
        $res=$choisirRepository->findByApprenant($connecter->getId());

       
        return $this->render('template_responsable_auto_ecole/choix_apprenant_rapport.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',"user"=>$user,
            "apprenants"=>$res,
        ]);
    }


    #[Route('/apprenat/inscrit', name: 'app_apprenant_inscrit')]
    public function apprenatInscrit(UserInterface $user,ChoisirRepository $choisirRepository, AutoEcoleRepository $autoEcoleRepository): Response
    {
        
        $a = $user->getUserIdentifier();
        $connecter = $autoEcoleRepository->findOneBy(array("Telephone"=>$a));
        $res=$choisirRepository->findByApprenant($connecter->getId());

       
        return $this->render('template_responsable_auto_ecole/liste_apprenant_inscrit.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',"user"=>$user,"apprenants"=>
            $res,
        ]);
    }

    #[Route('/template/portefeuille', name: 'app_portefeuille')]
    public function portefeuille(): Response
    {
       
        return $this->render("template_responsable_auto_ecole/portefeuille.html.twig",
        
    );
    }


    #[Route('/template/header', name: 'app_header')]
    public function header(): Response
    {
         
      
        $currentUser = $this->container->get('security.context')->getToken()->getUser();
        return $this->render("template_responsable_auto_ecole/header_responsable.html.twig",
        [
        
        ]);
    }

    #[Route('/template/responsable/auto/ecole/message_apprenant/{id}/notifications', name: 'app_notification_responsable')]
    public function notifapprenant(AutoEcoleRepository $autoEcoleRepository,MessageRepository $messageRepository)
    {   

        if (isset($_REQUEST["lu"])) {
            # code...
            $autoEcoleRepository->UpdateNotifications($_REQUEST["envoyerpar"]);
        }
        
        if (isset($_REQUEST["envoyerpar"])) {
            # code...
            $notifs = $messageRepository->findBy(array("lu"=>false,"RecuPar"=>$_REQUEST["envoyerpar"]));
            $a = count($notifs);
            $array = array("nombre"=>$a);
            return $this->json($array);
        }

        return $this->json([]);

    }

    #[Route('/template/responsable/auto/ecole/message_apprenant/{id}/listeNotifications', name: 'app_liste_notification_responsable')]
    public function listeNotifications(AutoEcoleRepository $autoEcoleRepository)
    {
        $mess = $autoEcoleRepository->listeNotifications($_REQUEST["envoyerpar"]);
        
        $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
        return $this->json($ar);
    }
}
